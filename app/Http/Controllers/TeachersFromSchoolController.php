<?php

namespace App\Http\Controllers;

use App\Options_Teachers;
use App\School;
use Illuminate\Http\Request;

class TeachersFromSchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $a = [];
        $school = School::find($request['school_id']);
        $teachers = ($school) ? $school->teachers() : [];

        if(count($teachers)){

            foreach($teachers AS $key => $teacher){

                $a[] = '<div class="custom-control custom-checkbox" >'
                        . '<input type="checkbox" class="custom-control-input" '
                            . 'id="customCheck'.$key.'" '
                            . 'name="teachers[]" '
                            . 'value="'.$teacher->id.'" '
                            . 'data-parsley-multiple="groups" '
                            . 'data-parsley-mincheck="0"> '
                        . '<label class="custom-control-label" for="customCheck'.$key.'">'
                            . $teacher->person->fullName
                        . '</label>'
                    . '</div>';
            }
        }

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
}
