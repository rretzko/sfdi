<!-- resources/views/emails/newstudent.blade.php -->
<p>Hi {{$teacher_name}}</p>
<p>{{$student_name}} has asked to be added to your Student Roster at {{$school_name}}.</p>
<p>{{$student_name}}'s basic profile is as follows:<br />
<ul>
    <li>Name: {{$student_name}}</li>
    <li>Class Of: {{$student->class_of}} (Grade {{$student->gradeClassOf}})</li>
</ul>
</p>
<p>{{$student_name}}'s complete record is available from your Student Roster.</p>
<p>Please <a href="{{ URL::signedRoute('studentaccepted', ['student' => $student_user_id, 'teacher' => $teacher_user_id]) }}" class="text-success">click here</a> to verify that {{$student_name}} is your student.</p>
<p>Otherwise, <a href="{{ URL::signedRoute('studentrejected', ['student' => $student_user_id, 'teacher' => $teacher_user_id]) }}" class="text-failure">click here</a> to remove {{$student_name}} from your Student Roster.</p>
<p>Best -<br />Rick Retzko<br />Founder, TheDirectorsRoom.com</p>