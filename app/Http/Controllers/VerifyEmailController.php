<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class VerifyEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, \App\Email $email)
    {
        //$user = \App\User::find(auth()->id());
        $person = \App\Person::find(auth()->id()); //$user->id);

        //IMPLEMENT TOKEN
        $verifyUser = \App\VerifyUser::create([
            'user_id' => $person->user_id,
            'token' => sha1(time()),
        ]);

        //INSTALL TOKEN IN EMAIL TARGET
        $email->verified = $verifyUser->token;
        $email->save();

        $type = ($person->emailPrimary === $email->email)
                ? 'primary' : 'alternate';

        event(new \App\Events\EmailAddedEvent($person, $type));

        //SEND VERIFICATION EMAIL
     //   \Mail::to($email->email)->send(new \App\Mail\VerifyMail($user, $type));

        $mssg = "Please log-out prior to clicking the link in the verification email.";
        Session::flash($type.'_email_advisory', $mssg);

        return view('pages.profile', self::arguments());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Build arguments list for view
     *
     * @return array
     */
    private function arguments() : array
    {
        $user = Auth::user();
        $user_id = $user->id;

        $grades_class_ofs = new \App\Grades_Class_Ofs();

        $student = \App\Student::find($user_id);

        return [
                'geo_states' => \App\Geostate::all(),
                'grades_class_ofs' => $grades_class_ofs->structure(),
                'user' => $user,
                'student' => $student,
                'person' => \App\Person::firstOrCreate(['user_id' => $user_id]),
                'pronouns' => \App\Pronoun::orderBy('order_by')->get(),
                'shirt_sizes' => \App\Shirtsize::orderBy('order_by')->get(),
                'nav_links' => self::nav_Links(),
                'choral' => \App\Instrumentation::orderBy('descr')->where('branch', 'choral')->get(),
                'instrumental' => \App\Instrumentation::orderBy('descr')->where('branch', 'instrumental')->get(),
                'student_chorals' => $student->chorals(),
                'student_instrumentals' => $student->instrumentals(),
                ];

    }

    /**
     * Initialize $this->nav_links array
     */
    private function nav_Links()
    {
        return [
            'credentials' => '',
            'event' => '',
            'parent' => '',
            'profile' => 'active',
            'school' => '',
            'student' => '',
        ];
    }
}
