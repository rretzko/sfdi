<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Table_Parents extends Model
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

            $this->table .= $this->build_Table_Headers();

            $this->table .= $this->build_Table_Rows();

        $this->table .= '</table><!-- end of table_Parents -->';
    }

    private function build_Table_Headers()
    {
        return '<thead>
                    <tr>
                        <th>Parent</th>
                        <th>Type</th>
                        <th>Email(s)</th>
                        <th>Phone(s)</th>
                    </tr>
                </thead>';
    }

    private function build_Table_Rows() : string
    {
        $str = '<tbody>';

        foreach($this->student->parentguardians AS $pg){

                $str .= '<tr>';
                    $str .= '<td>'
                            .'<a href="'.route('editParent',['parentguardian' => $pg->user_id]).'" title="Click to update '
                            .$pg->person->fullName.'\'s record">'
                            .$pg->person->fullName.'</a></td>';
                    $str .= '<td>'.$pg->guardiantypeDescription.'</td>';
                    $str .= '<td>'.$pg->emailBlock.'</td>';
                    $str .= '<td>'.$pg->phoneBlock.'</td>';
                    $str .= '<td></td>';
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

        $this->build_Table();
    }

    private function teachers($school_id)
    {
        $str = '';

        foreach($this->student->teachers AS $a){

            $t = Teacher::find($a->user_id);

            foreach($t->schools AS $collection){

                if($collection->id === $school_id){

                    $str .= $t->person->full_name.'<br />';
                }
            }
        }

        return $str;
    }
}

