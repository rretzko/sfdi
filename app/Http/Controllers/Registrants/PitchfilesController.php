<?php

namespace App\Http\Controllers\Registrants;

use App\Http\Controllers\Controller;
use App\Eventversion;
use App\Roster;
use App\Userconfig;

class PitchfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Eventversion $eventversion)
    {
        //use eventversion per user's last selection
        //$eventversion = Eventversion::find(Userconfig::eventversionValue());

        return view('pages.registrants.pitchfiles', [
            'eventversion' => $eventversion,

        ]);
    }
}
