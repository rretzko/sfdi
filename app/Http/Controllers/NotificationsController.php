<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $a = [];

        $missives = \App\Missive::where('sent_to_user_id', auth()->id())
                ->orderBy('statustype_id', 'asc') //alerts then checks
                ->orderBy('created_at', 'desc') //newest first
                ->get();
        
        foreach($missives AS $missive){
            
            $a['items'][] = self::formatItem($missive);
        }
        
        //display count of ALERTS not total number of missives
        $a['count'] = \App\Missive::where([
                ['sent_to_user_id', auth()->id()],
                ['statustype_id', 1],
            ])->count();
        
        echo json_encode($a); 
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
    
    private function formatItem(\App\Missive $missive): string
    {   
        $bg = ($missive->statusDescr === 'alert') ? 'bg-warning' : 'bg-success';
        $icon = ($missive->statusDescr === 'alert') ? 'mdi-email-alert' : 'mdi-check';
        
        return "<a href='".url('missive', [$missive->id])."' class='dropdown-item notify-item' '>"
                    . "<div class='notify-icon ".$bg."'>"
                        . "<i class='mdi ".$icon."'>"
                        . "</i>"
                    . "</div>"
                    . "<p class='notify-details'>"
                        . "<b>".$missive->header."</b>"
                        . "<span class='text-muted'>".$missive->excerpt."</span>"
                    . "</p>"
                . "</a>";
    }
}
