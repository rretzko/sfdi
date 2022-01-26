<?php

namespace App\Http\Controllers\Auth;

use App\Address;
use App\Email;
use App\Emailtype;
use App\Http\Controllers\Controller;
use App\Nonsubscriberemail;
use App\Person;
use App\Student;
use App\Teacher;
use App\User;
use App\Traits\BlindIndex;
use App\Traits\UserName;
use App\Traits\SeniorYear;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller

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

    public function showRegistrationForm()
    {
        $persons = Person::whereIn('user_id', Teacher::pluck('user_id')->toArray())
            ->select('last','user_id')
            ->get('last');
        $teachers = Teacher::with('person')
            ->get('user_id','person.last');

        return view('pages.sfdiauths.register');
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
        if($this->isDuplicateStudent($data)) {

            return route('duplicatestudent', ['data' => $data]);

        }else{

            $user = User::create([
                'username' => $this->createUserName($data['first_name'], $data['last_name']),
                'password' => Hash::make($data['password']),
            ]);
        }

        if ($user->id) {

            $person = Person::create([
                'user_id' => $user->id,
                'first' => $data['first_name'],
                'middle' => '', //stub value to allow encryption
                'last' => $data['last_name'],
            ]);

            //ensure a student object is available
            $student = Student::create([
                'user_id' => $user->id,
                'class_of' => self::SeniorYear()
            ]);

            //EMAILS
            if (strlen($data['email'])) {
                Nonsubscriberemail::create([
                    'user_id' => $user->id,
                    'emailtype_id' => Emailtype::where('descr', 'email_student_personal')->first()->id,
                    'email' => $data['email'],
                ]);
            }
            //$email_primary = self::email($data['email']);

            //$email_alternate = self::email('');

            //$person->emails()->attach($email_primary->id, ['type' => 'primary']);
            //$person->emails()->attach($email_alternate->id, ['type' => 'alternate']);

            //ADDRESS
            //create a row of encrypted blank values
            Address::create([
                'user_id' => $user->id,
                'address01' => '',
                'address02' => '',
                'city' => '',
                'geostate_id' => 37,
                'postalcode' => '',
            ]);
        }

        //send email verification letter if not already verified
        //if(strlen($email_primary->email) &&
        //    (!$email_primary->is_verified())){

        //     event(new \App\Events\NewRegistrationEvent($student));

        // }else{ //user is using an already verified email; i.e. family email

        //    $user->verified = 1;
        //   $user->save();
        //}

        Auth::login($user);

        return $user;
    }

    private function email($search_email)
    {dd(__METHOD__);
        $blind_index = self::BlindIndex($search_email);

        return (Email::where('blind_index', '=', $blind_index)->exists())
            ? Email::where('blind_index', '=', $blind_index)->first()
            : Email::create([
                'email' => $search_email,
                'blind_index' => $blind_index
                ]);
    }

    /**
     * Determine if student record exists by comparing student last name
     * email, school, teacher, and grade against the database records
     *
     * @param array $data
     */
    private function isDuplicateStudent(array $data)
    {
        $strength = 0;
        $inputemail = $data['email'];
        $classof = ($this->SeniorYear() + (12 - $data['grade']));
        $user_ids = Person::where('last', $data['last_name'])->pluck('user_id')->toArray();

        //user_ids which match last name and classof
        return Student::whereIn('user_id', $user_ids)
            ->where('classof', $classof)
            ->pluck('user_id')->count();
    }

    protected function redirectTo($data)
    {
        return route('duplicatestudent', ['data' => $data]);
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
            'school' => ['required','string', 'min:4', 'max:255'],
            'teacher_first' => ['required', 'string', 'min:1', 'max:255'],
            'teacher_last' => ['required', 'string', 'min:1', 'max:255'],
            'grade' => ['required','numeric','min:1','max:12'],
            'voicepart' => ['required','string', 'min:6', 'max:36'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}
