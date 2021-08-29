<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MissiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.missives', self::arguments());
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
    public function show(\App\Missive $missive)
    {
        //isolate the "reviewed" status type id
        $statustype = \App\Statustype::firstWhere('descr', 'reviewed');
    
        //update $missive statustype_id to "reviewed" from "alert" (if necessary)
        $missive->update(['statustype_id' => $statustype->id]);

        return view('pages.missive', [
            'missive' => $missive,
            'sender' => $missive->sentByUserName
                ]);
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
    
    private function arguments() : array
    {
        $table = new \App\Table_Missives;
        
        return ['table' => $table->table()];
    }
}
