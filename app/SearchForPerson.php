<?php

namespace App;

use App\Traits\BlindIndex;
use Illuminate\Database\Eloquent\Model;

class SearchForPerson extends Model
{
    private $collection;
    private $email_alternate;
    private $email_primary;
    private $first_name;
    private $last_name;
    private $phone_cell;
    private $user_id;

    //2021-08-28
    private $email_home;
    private $email_work;
    private $email_other;
    private $email_guardian_primary;
    private $email_guardian_alternate;
    private $email_student_personal;
    private $email_student_school;
    private $phone_mobile;
    private $phone_guardian_mobile;
    private $phone_student_mobile;
    private $emails;
    private $phones;

    use BlindIndex;

    public function __construct(array $request)
    {
        self::init($request);
    }

    public function collection()
    {
        return $this->collection;
    }

    /** END OF PUBLIC FUNCTIONS ***********************************************/

    private function addCollection(Person $person)
    {
        $this->collection->push($person);

    }

    private function findEmail()
    {
        //2021-08-28
        if(! empty($this->emails)) {

            $subscribers = Subscriberemail::all();
            $nonsubscribers = Nonsubscriberemail::all();

            foreach ($this->emails as $email) {

                foreach ($subscribers as $subscriber) {

                    if (strtolower($email) === strtolower($subscriber->email)) {

                        self::addCollection(Person::find($subscriber->user_id));
                    }
                }

                foreach ($nonsubscribers as $nonsubscriber) {

                    if (strtolower($email) === strtolower($nonsubscriber->email)) {

                        self::addCollection(Person::find($nonsubscriber->user_id));
                    }
                }
            }
        }

/*
        if(strlen($this->$email_type)){ //input has value

            $email = Email::firstWhere('blind_index',
                    self::BlindIndex($this->$email_type));

            if($email){ //email is found

                self::addCollection($email->people);
            }
        }
*/
    }

    private function findPhone()
    {
        //2021-08-28
        if(! empty($this->phones)) {

            $phones = Phone::all();

            foreach ($this->phones as $phone) {

                foreach ($phones as $known) {

                    if ($phone === $known->phone) {

                        self::addCollection(Person::find($known->user_id));
                    }
                }

            }
        }
        /*
        $phone_type = 'phone_'.$type;

        if(strlen($this->$phone_type)){ //input has value

            $phone = Phone::firstWhere('blind_index',
                    self::BlindIndex($this->$phone_type));

            if($phone){ //phone is found

                self::addCollection($phone->people);
            }
        }
        */
    }

    private function init($request)
    {
        /** set variables */
        $this->collection = collect();
        $this->user_id = [];
        $this->first_name = (array_key_exists('first_name', $request))
                ? $request['first_name'] : '';
        $this->last_name = (array_key_exists('last_name', $request))
                ? $request['last_name'] : '';

        //2021-08-28
        $emailtypes = ['email_home','email_other', 'email_work',
            'email_guardian_alternate', 'email_guardian_primary',
            'email_student_personal', 'email_student_school'];

        foreach($emailtypes AS $emailtype){
            if(array_key_exists($emailtype,$request) && strlen($request[$emailtype])) {
                $this->emails[] = $request[$emailtype];
            }
        }

        $phonetypes = ['phone_home','phone_mobile','phone_work',
            'phone_guardian_home', 'phone_guardian_mobile', 'phone_guardian_work',
            'phone_student_home', 'phone_student_mobile', 'phone_student_work'];

        foreach($phonetypes AS $phonetype) {
            if (array_key_exists($phonetype, $request) && strlen($request[$phonetype])) {
                $this->phones[] = $request[$phonetype];
            }
        }

        self::findEmail();
        self::findPhone();

        /* for testing */
        if(!is_null($this->collection)){
            foreach($this->collection AS $person){

                //dd($person->fullName);
            }
        }
    }
}
