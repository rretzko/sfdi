<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Table_Events extends Model
{
    protected $table;
    private $student;

    public function __construct(Student $student)
    {
        $this->init($student);
    }

    public function table() : string
    {
        return $this->table;
    }

/******************************************************************************/
    private function build_Table()
    {
        $this->table = '<table id="datatable" '
                . 'class="table dt-responsive nowrap datatable-styling">';

            $this->table .= $this->build_Table_Headers();

            $this->table .= $this->build_Table_Rows();

        $this->table .= '</table><!-- end of table_Events -->';
    }

    private function build_Table_Headers()
    {
        return '<thead>
                    <tr>
                        <th>Organization</th>
                        <th>Event</th>
                        <th>Version</th>
                        <th>Auditioned</th>
                        <th>Score</th>
                        <th>Result</th>
                    </tr>
                </thead>';
    }

    private function build_Table_Rows() : string
    {
        $str = '<tbody>';

        /**
         * @todo move this into a scope for: eligible events
         * @todo add 'where teacher has been invited to participate' condition
         */
        foreach(Organization::orderBy('abbr')->get() AS $org){
            foreach($org->events->where('status', 'active') AS $event){
                $grades = explode(',',$event->grades);
                foreach($event->eventversions AS $version){

                    $status = ($version->status === 'active') //version completed
                            ? 'myEvent'
                            : '';
                    if(
                            ($this->student->class_of >= $version->senior_class_of) &&
                            (in_array($this->student
                                    ->calcGradeFromSeniorYear($version->senior_class_of),$grades))
                        ){

                            $version_name = ($version->status === 'closed')
                                    ? $version->version_name
                                    : '<a href="version/'.$version->id.'">'
                                        .$version->version_name.'</a>';

                            $str .= '<tr class="'.$status.'">';
                            $str .= '<td>'.$org->abbr.'</td>';
                            $str .= '<td>'.$event->event_name.'</td>';
                            $str .= '<td>'.$version->name.'</td>';
                            $str .= '<td class="text-center">'.self::dummy_Voicings().'</td>';
                            $str .= '<td>'.self::dummy_Scores().'</td>';
                            $str .= '<td>'.self::dummy_Results().'</td>';
                            $str .= '</tr>';
                        }
                    }
                }
            }


        $str .= '</tbody>';

        return $str;
    }

    /**
     * ACC = Accepted
     * NA  = Not Accepted
     * INC = Incomplete
     * NS  = No Show
     * NP  = Non-participant
     *
     * @return string
     */
    private function dummy_Results()
    {
        $voicings = ['ACC', 'NA', 'INC', 'NS', 'NP'];

        return $voicings[random_int(0, 4)];
    }

    private function dummy_Scores()
    {
        return random_int(130, 427);
    }

    private function dummy_Voicings()
    {
        $voicings = ['SI', 'SII', 'AI', 'AII', 'TI', 'TII', 'BI', 'BII'];

        return $voicings[random_int(0, 7)];
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

