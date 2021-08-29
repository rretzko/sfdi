<?php

namespace App\Http\Controllers;

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //\App\Http\Requests\School_AddStore
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if($validator->fails()){

            Session::flash('error', $validator->messages()->first());
            return redirect()->back()->withInput();
        }

        $user = (\App\User::where('name', $request['name'])->exists())
                ? \App\User::firstWhere('name', $request['name'])
                : NULL;

        if(!$user){

            Session::flash('err', 'Unknown user name.');

            return redirect()->back()->withInput();

        }

        $person = \App\Person::find($user->id);

        if(!strlen($person->emailPrimary)){

            Session::flash('err', 'No email found to send reset notice.');

            return redirect()->back()->withInput();
        }

        event(new \App\Events\ResetPasswordRequestEvent($person));

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
