<?php

namespace App;

use App\Person;
use App\Traits\BlindIndex;
use App\Traits\Encryptable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Email extends Model
{
    use BlindIndex;
    use Encryptable;
    use SoftDeletes;

    protected $encryptable = [ //encryptable fields
        'email',
        ];

    protected $fillable = [
        'blind_index',
        'email',
        'type',
        'user_id',
        ];

    public function add($email, Person $person, $type)
    {
        self::find_Or_Create($email, $person, $type);
    }

    /**
     * Return a blank email object
     * if row does not exists, create row
     * Expected row is missing ONCE, then added to database
     * @return \App\Email
     */
    public function blank_Email() : Email
    {
        return  (Email::firstWhere('blind_index', self::BlindIndex('')))
                ?: Email::firstOrCreate([
                    'email' => '',
                    'blind_index' => self::BlindIndex(''),
                    'verified' => '0',
                ]);
    }

    /**
     * Delete all links to $person emails
     *
     * @return bool
     */
    public function clearAllLinks(Person $person)
    {
        return DB::table('email_person')
                ->where('user_id', '=', $person->user_id)
                ->delete();
    }

    public function is_Verified() : bool
    {
        return ($this->verified === "1");
    }

    public function people()
    {
        return $this->belongsToMany(Person::class, 'email_person',
                'email_id', 'user_id')
                ->withTimestamps()
                ->withPivot('type');
    }

    public function verify_Token($token)
    {
        if($this->verified === $token){

            $this->verified = 1;
            $this->save();
        }
    }

/** END OF PUBLIC FUNCTIONS ***************************************************/

    private function add_New_Non_Teacher_Email($email, Person $person, $type,
            $blind_index=null){

        if(! $this->id){
            $this->email = $email;
            $this->blind_index = (($blind_index) ?: self::BlindIndex($email));
            $this->verified = 0;
            $this->teacher_user_id = 0;
            $this->type = $type;
            $this->save();
        }

        self::add_New_Non_Teacher_Email_Link($person, $type);

        return $this->id;
    }

    private function add_New_Non_Teacher_Email_Link(Person $person, $type) : bool
    {
        return DB::table('email_person')->insert([
            'email_id' => $this->id,
            'user_id' => $person->user_id,
            'type' => $type,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    private function find_Or_Create($email, Person $person, $type) : int
    {
        $blind_index = self::BlindIndex($email);

        //search for existing email
        $this->id = DB::table('emails')
                ->select('id')
                ->where('blind_index', '=', $blind_index)
                ->value('id');

        //create a new email if none found or $test_id passes teacher challenge
        if((! $this->id) ||
                self::teacher_Unique_Email_Challenge($person, $type)){ /*remove type */

            return self::add_New_Non_Teacher_Email($email, $person, $type,
                    $blind_index);
        }

        return 0;
    }

    private function teacher_Unique_Email_Challenge(Person $person, $type=null) : bool
    {
        $teacher_user_id = (! $this->id) //maybe unnecessary step
                ? 0
                : DB::table('emails')
                ->select('teacher_user_id')
                ->where('id', '=', $this->id)
                ->value('teacher_user_id');

        //teacher_unique_email_challenge
        if($teacher_user_id && ($teacher_user_id != $person->user_id)){

            $teacher = Teacher::find($teacher_user_id);
            $email = ($this->id == 10) ? 'no email' : $this->email;
            
            error_log('FJR: student '.auth()->user()->id.' is attempting to '
                    . 'add '.$email.' for parent: '.$person->user_id.' ('
                    . $person->fullName.').  This email is already in use by '
                    . 'teacher_user_id: '.$teacher_user_id.' ('
                    . $teacher->person->fullName.').');

            return false;
        }

        return true;
    }
}
