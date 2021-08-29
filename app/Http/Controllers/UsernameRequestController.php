<?php

namespace App\Http\Controllers;

use App\Email;
use App\Http\Controllers\Controller;
use App\Nonsubscriberemail;
use App\Person;
use App\Student;
use App\User;
use App\Traits\BlindIndex;
use App\Traits\UserName;
use App\Traits\SeniorYear;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class UsernameRequestController extends Controller

{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use BlindIndex;
    use RegistersUsers;
    use SeniorYear;
    use UserName;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        //find Nonsubscriberemail objects matching this email
        $emails = Nonsubscriberemail::where('email', $data['email'])->get();

        if(! $emails->count()){

            $warning = $request['email'].' was not found. Please use the Chat '
                    . 'button in the bottom right-hand corner if you think this '
                    . 'is in error. ';

            return redirect(route('login'))->with('warning', $warning);
        }

        event(new \App\Events\UsernameReminderEvent($emails));

        $status = 'Your username has been sent to: '.$request['email'].'.';

        return redirect(route('login'))->with('status', $status);
    }

/** END OF PUBLIC METHODS *****************************************************/
    private function findStudentUsers(array $data) : array
    {
        return Nonsubscriberemail::where('email', $data['email'])->get();

        /*$sql = 'SELECT a.user_id '
                . 'FROM email_person a, emails b, school_student c '
                . 'WHERE b.blind_index="'.$blind_index.'" '
                . 'AND b.id=a.email_id '
                . 'AND a.user_id=c.student_user_id '
                . 'AND NOT '
                . '('
                    . 'SELECT EXISTS(SELECT d.school_id FROM school_teacher d '
                    . 'WHERE d.teacher_user_id=a.user_id)'
                . ')';

        return DB::select($sql) ?? [];
        */
    }

/** DELETE EVERYTHING BELOW THIS LINE *****************************************/
    public function verifyUser($token)
    {
      $verifyUser = \App\VerifyUser::where('token', $token)->first();

      if(isset($verifyUser) ){//token is found

        $user = $verifyUser->user;

        /* VERIFY USER */
        if(!$user->verified){ //user has not been previously verified
            $user->verified = 1;
            $user->save();
        }

        $person = Person::find($user->id);

        /* VERIFY USER PRIMARY EMAIL */
        $email = $person->emailPrimaryObject;
        $email->verify_Token($token);

        $status = "Thanks! Your primary email has been verified!";

      } else {

          return redirect('/login')->with('status', "Sorry your email cannot be identified.");
      }

      return redirect('/login')->with('status', $status);
    }

/** END OF PUBLIC EVENTS ******************************************************/

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $this->createUserName($data['first_name'], $data['last_name']),
            'password' => Hash::make($data['password']),
        ]);

        if($user->id){

            $person = Person::create([
                'user_id' => $user->id,
                'first_name' => $data['first_name'],
                'middle_name' => '', //stub value to allow encryption
                'last_name' => $data['last_name'],
            ]);

            //ensure a student object is available
            $student = Student::create([
                    'user_id' => $user->id,
                    'class_of' => self::SeniorYear()
                ]);

            //EMAILS
            $email_primary = self::email($data['email']);

            $email_alternate = self::email('');

            $person->emails()->attach($email_primary->id, ['type' => 'primary']);
            $person->emails()->attach($email_alternate->id, ['type' => 'alternate']);
        }

        //send email verification letter if not already verified
        if(strlen($email_primary->email) &&
            (!$email_primary->is_verified())){

            event(new \App\Events\NewRegistrationEvent($student));

        }else{ //user is using an already verified email; i.e. family email

            $user->verified = 1;
            $user->save();
        }

        Auth::login($user);

        return $user;

    }

    private function email($search_email)
    {
        $blind_index = self::BlindIndex($search_email);

        return (Email::where('blind_index', '=', $blind_index)->exists())
            ? Email::where('blind_index', '=', $blind_index)->first()
            : Email::create([
                'email' => $search_email,
                'blind_index' => $blind_index
                ]);
    }

    protected function redirectTo()
    {
        return route('profile');
    }

    protected function registered(Request $request, $user)
    {
        return redirect()->route('pending_verification');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255',],// 'unique:emails,blind_index'
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
