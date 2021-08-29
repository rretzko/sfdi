<?php

namespace App\Http\Controllers\Signeds;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentrejectedController extends Controller
{
    public function __invoke(Request $request, \App\Student $student, \App\Teacher $teacher) 
    {
        if($request->hasValidSignature()){
        
            $teacher->rejectStudent($student);
        }
        
        return redirect('https://thedirectorsroom.com'); 
    }
    
/** END OF PUBLIC FUNCTIONS ***************************************************/
    
}
