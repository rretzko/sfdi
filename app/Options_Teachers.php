<?php

namespace App;

use App\School;
//use Illuminate\Database\Eloquent\Model;

/**
 * Return string of <option></option> for persons identified as teachers 
 * in $attributes['school'] = App/School
 */
class Options_Teachers //extends Model
{
    private $options;
    
    public function __construct(array $attributes = array()) 
    {
        /** @var initialize $this->options string */
        $this->options = '';
        
        self::build_Options($attributes['school']);
    }
    
    public function options() : string
    {
        return $this->options;
    }
    
/** END OF PUBLIC INTERFACE ***************************************************/    
    
    private function build_Options(School $school)
    {
        $teachers = $school->teachers;
        
        $checked = (count($teachers) === 1) ? 'CHECKED' : '';
     
        foreach($school->teachers AS $key => $teacher){
            
            $this->options .= '<div class="form-check">';
            
            $this->options .= '<input type="checkbox" '
                    . 'class="form-check-input" '
                    . 'name="teachers[]" '
                    . 'id="teacher_'.$key.'" '
                    . 'value="'.$teacher->user_id.'" '
                    . $checked
                    . '/>';
            
            $this->options .= '<label for="teacher_'.$key.'" '
                    . 'class="form-check-label" >'
                    . $teacher->person->fullNameAlpha
                    . '</label>';
            
            $this->options .= '</div>';
            //$this->options .= '<option value="'.$teacher->user_id.'">'.$teacher->person->first_name.'</option>';
        }
         
        
    }
}
