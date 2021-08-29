<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Table_Schools extends Model
{
    protected $table;
    private $student;

    public function __construct(Student $student)
    {
        self::init($student);
    }

    public function table() : string
    {
        return $this->table;
    }

/******************************************************************************/
    private function build_Table()
    {
        $this->table = '<table id="table_Schools" '
                . 'class="table table-responsive-sm">';

            $this->table .= self::build_Table_Headers();

            $this->table .= self::build_Table_Rows();

        $this->table .= '</table><!-- end of table_Schools -->';
    }

    private function build_Table_Headers()
    {
        return '<thead>
                    <tr>
                        <th>School</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Teacher(s)</th>
                        <th>Class of</th>
                    </tr>
                </thead>';
    }

    private function build_Table_Rows() : string
    {
        $str = '<tbody>';

        foreach($this->student->schools AS $school){

                $str .= '<tr>';
                    $str .= '<td>'.$school->name.'</td>';
                    $str .= '<td>'.$school->city.', '.$school->geoStates.'</td>';
                    $str .= '<td>'.$this->student->getStatusAtSchool($school->id).'</td>';
                    $str .= '<td>'.self::teachers($school->id).'</td>';
                    $str .= '<td>'.$this->student->gradeClassOf.'</td>';
                $str .= '</tr>';
        }

        $str .= '</tbody>';

        return $str;
    }

    private function init(Student $student)
    {
        /** initialize vars **/
        $this->student = $student;
        $this->table = '';

        self::build_Table();
    }

    private function teachers($school_id)
    {
        $str = '';

        foreach($this->student->teachers AS $teacher){

            foreach($teacher->person->user->schools AS $school){

                if($school->id === $school_id){

                    $str .= $teacher->person->full_name.'<br />';
                }
            }
        }

        return $str;
    }
}

