<?php

namespace App\Http\Controllers;

use App\Nonsubscriberemail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class PasswordResetRequestController extends Controller
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
     * 223pdoherty@frhsd.com
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //\App\Http\Requests\School_AddStore
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if($validator->fails()){

            Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput();
        }

        $nonsubscriber = new Nonsubscriberemail();
        //array of user objects
        $users = $nonsubscriber->getUserFromEmail($request['email']);

        if(! count($users)){

            Session::flash('err', 'Unknown email address: '.$request['email'].' .');

            return redirect()->back()->withInput();

        }
//dd($users[0]['person']['student']->emailSchool);

        event(new \App\Events\ResetPasswordRequestEvent($users));

        Session::flash('status', 'Your password-reset email has been sent.');

        return redirect('/login');
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
