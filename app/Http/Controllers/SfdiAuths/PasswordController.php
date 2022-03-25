<?php

namespace App\Http\Controllers\SfdiAuths;

use App\Events\ResetPasswordRequestEvent;
use App\Http\Controllers\Controller;
use App\Nonsubscriberemail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PasswordController extends Controller
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
        return view('pages.sfdiauths.forgotpassword');
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
    public function update(Request $request)
    {
        $input = $request->validate([
           'email' => ['required', 'email'],
        ]);

        $emails = Nonsubscriberemail::all()->filter(function($nonsubscriberemail) use($input){
            return $nonsubscriberemail->email === $input['email'];
        });

        //ensure at least one email is found
        if($emails->first()) {

            event(new ResetPasswordRequestEvent($emails));

            Session::flash('message', 'Password-reset email sent to:' . $emails->first()->email . ' .');
            return view('auth.login');

        }elseif(! $emails->count()){

            Session::flash('message', '"'.$input['email'].'" was not found. Do you use another email address?');
            return view('auth.login');

        }else{

            mail('rick@mfrholdings.com', 'Password reset: bad email', 'The following email was used
            to attempt a password-reset: '.$input['email'].' @ '.__CLASS__.': '.__METHOD__.': '.__LINE__.' ('.date('Y-M-d G:i:s', strtotime('NOW')).')');
            Session::flash('message', 'An unexpected error has occurred and the system administrator has been notified');
            return view('auth.login');

        }
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
}
