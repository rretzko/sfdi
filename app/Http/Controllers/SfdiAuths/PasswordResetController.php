<?php

namespace App\Http\Controllers\SfdiAuths;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class PasswordResetController extends Controller
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
    public function store(Request $request, $token)
    {
        $pr = \App\PasswordResets::firstWhere('token', $token);

        if(!$pr){

            Session::flash('err', 'Unable to find this token. Please use the most current email!');
            return redirect('/password/reset');
        }

        //user has maximum of one-hour past token creation to activate reset
        $max_time = Carbon::parse($pr->created_at)->addHour();

        if($max_time->lt(Carbon::now())){

            Session::flash('warning', 'Your password-reset time has expired.');
            return redirect(route('home'));

        }else{

            auth()->login(\App\User::find($pr->user_id));

            Session::flash('user_id', $pr->user_id);

            return view('pages.confirm');
        }
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
