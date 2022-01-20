<?php

namespace App\Http\Controllers\SfdiAuths;

use App\Http\Controllers\Controller;
use App\Person;
use App\Student;
use App\Traits\SeniorYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    use SeniorYear;

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
        $inputs = $request->validate(
            [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255',],// 'unique:emails,blind_index'
                'school' => ['required','string', 'min:4', 'max:255'],
                'teacher_first' => ['required', 'string', 'min:1', 'max:255'],
                'teacher_last' => ['required', 'string', 'min:1', 'max:255'],
                'grade' => ['required','numeric','min:1','max:12'],
                'voicepart' => ['required','string', 'min:4', 'max:36'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]
        );

        if($this->isDuplicateStudent($inputs)){

            Session::put('inputs', $inputs);
            return redirect()->route('sfdi.duplicatestudent');
        }

        //expected behavior
        //go to profile page
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

    private function isDuplicateStudent($data)
    {
        $strength = 0;
        $inputemail = $data['email'];
        $classof = ($this->SeniorYear() + (12 - $data['grade']));
        $user_ids = Person::where('last', $data['last_name'])->pluck('user_id')->toArray();

        //user_ids which match last name and classof
        return Student::whereIn('user_id', $user_ids)
            ->where('classof', $classof)
            ->pluck('user_id')->count();
    }
}
