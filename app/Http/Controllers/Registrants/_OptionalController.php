<?php

namespace App\Http\Controllers\Registrants;

use App\Http\Controllers\Controller;
use App\Registrant;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OptionalController extends Controller
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
     * @param  \App\Registrant $registrant
     * @return \Illuminate\Http\Response
     */
    public function edit(Registrant $registrant)
    {
        $student = $registrant->student;

        return view('pages.dossiers.optional', [
            'registrant' => $registrant,
            'student' => $student,
            'page_title' => 'Optional Profile Information',
            'shirt_sizes' => \App\Shirtsize::orderBy('order_by')->get(),
            'auditionnumber' => $registrant->auditionnumber,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Registrant $registrant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Registrant $registrant)
    {
        $student = $registrant->student;

        $student->update([
            'height' => $request['height'],
            'shirt_size' => $request['shirt_size'],
            'updated_by' => auth()->user()->id,
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('registrant.show', ['registrant' => $registrant]);
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

/** END OF PUBLIC FUNCTIONS ***************************************************/

}
