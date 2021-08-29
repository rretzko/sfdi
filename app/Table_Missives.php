<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Table_Missives extends Model
{
    protected $table;
    
    public function __construct()
    {
        self::init();
    }
    
    public function table() : string
    {
        return $this->table;
    }
    
/******************************************************************************/
    private function build_Table()
    {
        $this->table = '<table id="table_Missives" '
                . 'class="table table-responsive-sm">';
        
            $this->table .= self::build_Table_Headers();
            
            $this->table .= self::build_Table_Rows();
            
        $this->table .= '</table><!-- end of table_Missives -->';
    }
    
    private function build_Table_Headers()
    {
        return '<thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Header</th>
                        <th>Excerpt</th>
                        <th>Message</th>
                        <th>Sent By</th>
                    </tr>
                </thead>';
    }
    
    private function build_Table_Rows() : string
    {
        $str = '<tbody>';
        
        foreach($this->student->person->missivesLifo AS $missive){
      
            $str .= '<tr>';
                $str .= '<td>'.$missive->created_at->format('F d, Y g:i a').'</td>';
                $str .= '<td>'.$missive->statusDescr.'</td>';
                $str .= '<td>'.$missive->header.'</td>';
                $str .= '<td>'.$missive->excerpt.'</td>';
                $str .= '<td>'.$missive->missive.'</td>';
                $str .= '<td>'.$missive->sentByUserName.'</td>';
            $str .= '</tr>';
        }

        $str .= '</tbody>';
        
        return $str;
    }
    
    private function init()
    {
        /** initialize vars **/
        $this->student = Student::find(auth()->id());
        $this->table = '';
        
        self::build_Table();
    }
    
}

