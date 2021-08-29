<?php

use App\Email;
use App\Person;
use App\Phone;
use App\User;
use App\Traits\BlindIndex;
use App\Traits\FormatPhone;
use App\Traits\UserName;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Transfer user records from old database into new schema
 * 
 * User records are both directors and students
 * 
 * 1. Load $this->seeds array from external .csv files (directors.csv, students.csv)
 * 2. Extract and transform related data
 *      - birthday
 *      - gender => pronouns
 *      - shirt-size
 * 3. Load array data into user tables:
 *      - people
 *      - students
 *      - users
 *      - 
 */
class PeopleSeeder extends Seeder
{
    use BlindIndex;
    use FormatPhone;
    use UserName;
    
    private $links;
    private $seeds;
    
    public function __construct() {
        
        //instantiate vars
        $this->links = [];
        $this->seeds = [];
        
        //populate $this->seeds with director data
        self::build_Directors();
        
        //populate $this->seeds with student data
        self::build_Students();
        
        
    }
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(count($this->seeds)){
        
            foreach($this->seeds AS $key => $seed){
            
                $user_id = ($key + 1); //avoid '0' index for $this->seeds
                
                //load associated user table
                self::run_User($user_id, $seed);
                
                //load associated people tables
                self::run_People($user_id, $seed);
                
                //load associated student tables
                self::run_Student($user_id, $seed); 
                
                //load associated teacher tables
                //self::run_Teacher($user_id, $seed);
            }
            
            /**
             * load student-associated parents
             *
             * this is outside of the primary for-loop because $user_ids need 
             * to be assigned outside of the forced $user_id calculation used 
             *  in the for-loop
             * 
             */
            self::run_Parents();
            
            /**
             * load organization data
             */
            self::run_Organizations();
        } 
    }
/** END OF PUBLIC FUNCTIONS ***************************************************/    
    
    private function build_Common_Properties(array $data) : array
    {
        return [
                'old_id' => $data[0],
                'school_id_1' => $data[1],
                'school_id_2' => $data[2],
                'school_id_3' => $data[3],
                'first_name' => $data[4],
                'middle_name' => $data[5],
                'last_name' => $data[6],
                'pronoun_id' => $data[7],
                'honorifics_id' => $data[8],
                'email_primary' => $data[9],
                'email_alternate' => $data[10],
                'phone_mobile' => $data[11],
                'phone_work' => $data[12],
                'phone_home' => $data[13],
            ];
    }
    
    private function build_Directors()
    {
        if(file_exists('resources/docs/directors.csv')){
        
            $res = fopen('resources/docs/directors.csv', 'rb');
            
            $first_row = true;
            
            while(($data = fgetcsv($res)) !== false){
                
                if($first_row) { //skip first row of labels
                    
                    $first_row = false;
                    
                }else{
                    
                    $this->seeds[] = self::build_Common_Properties($data);
                }
            }
            
            fclose($res);
        }       
    }
    
    /**
     * Only non-existent or blank emails are injected
     * 
     * @param email $email or blank
     * @return blank email if empty($email) 
     */
    private function build_Email($email) : Email
    {
        static $blank_email = NULL;
        
        //do this once
        if(is_null($blank_email)){
            $blank_email = \App\Email::firstWhere(
                    'blind_index', self::BlindIndex('')
                    );
        }
        
        return (strlen($email))
            ? \App\Email::create([
                    'email' => $email,
                    'blind_index' => self::blindIndex($email),
                 ])
            : $blank_email;
    }
    
    /**
     * Only non-existent or blank phones are injected
     * 
     * @param email $phone or blank
     * @return blank phone if empty($phone) 
     */
    private function build_Phone($phone) : Phone
    {
        static $blank_phone = NULL;
        
        //do this once
        if(is_null($blank_phone)){
            $blank_phone = \App\phone::firstWhere(
                    'blind_index', self::BlindIndex('')
                    );
        }
        
        $fphone = self::FormatPhone($phone);
        
        return (strlen($phone))
            ? \App\Phone::create([
                    'phone' => $fphone,
                    'blind_index' => self::blindIndex($fphone),
                 ])
            : $blank_phone;
    }
    
    private function build_Students()
    {
        $res = fopen('resources/docs/students.csv', 'rb');
       
        if(is_resource($res)){ 
            
            $first_row = true;
        
            while(($data = fgetcsv($res)) !== false){

                if($first_row){ //skip first row of labels
                    
                    $first_row = false;
                    
                }elseif(is_numeric($data[15])){ //grade or classof
                
                    $common = self::build_Common_Properties($data);

                    $student = [
                        'voice_part' => $data[14],
                        'class_of' => $data[15],
                        'shirt_size' => $data[16],
                        'birthday' => self::calc_Birthday($data),
                        'height' => self::calc_Height($data[20]),
                        'address_01' => $data[21],
                        'address_02' => $data[22],
                        'city' => $data[23],
                        'geo_state_abbr' => $data[24],
                        'postal_code' => self::calc_Postal_Code($data[25]),
                        'parentguardiantype_id' => 1, //mother
                        'pg_first_name' => $data[27],
                        'pg_middle_name' => $data[28],
                        'pg_last_name' => $data[29],
                        'pg_email_primary' => $data[30],
                        'pg_email_alternate' => $data[31],
                        'pg_phone_home' => $data[32],
                        'pg_phone_mobile' => $data[33],
                        'pg_phone_work' => $data[34],
                        'director_id_1' => $data[35],
                        'director_id_2' => $data[36],
                        'director_id_3' => $data[37],
                    ];

                    $this->seeds[] = array_merge($common, $student);
                    
                }else{
                    
                    //do nothing; id_schools is blank = invalid row
                }
            }

            fclose($res);
        }
    }
    
    /**
     * Return $dt as YYYY-MM-DD format
     * 
     * @param array $data
     * @return string
     */
    private function calc_Birthday(array $data) : string
    {
       return (is_numeric($data[17]) &&  //year
                is_numeric($data[18]) && //month
                is_numeric($data[19]))   //day
            ? Carbon::create($data[17],$data[18],$data[19]) 
            : Carbon::now();
    }
    
    private function calc_Geo_State_Id($abbr) : int
    {
        $founds = [];
        
        if(! array_key_exists($abbr, $founds)){
            
            $founds[$abbr] = DB::table('geo_states')
                ->select('id')
                ->where('abbr' , $abbr)
                ->value('id');
        }
        
        return $founds[$abbr];
    }
    
    /**
     * @since 2020.01.20
     * 
     * @param int $height
     * @return int
     */
    private function calc_Height($height) : int
    {
        return (is_numeric($height)) ? $height : 36;
    }
    
    private function calc_Postal_Code($postal_code)
    {
        if(! strlen($postal_code)){
            
            return '';
        }elseif((strlen($postal_code) > 4)){
            
            return $postal_code;
            
        }else{ //ex. NJ postal_code 08873 with truncated leading "0" 
            
            return '0'.$postal_code;
        }
    }
    
    private function find_Email($email) : int
    {
        //early exit
        if(! strlen($email)){return false;}
        
        $test = \App\Email::firstOrNew([
                    'blind_index' => self::blindIndex($email),
                ]);
        
        return $test->id ?? 0;
    }
    
    private function find_Phone($phone) : int
    {
        //early exit
        if(! strlen($phone)){return false;}
        
        $fphone = self::FormatPhone($phone);
        
        $test = \App\Phone::firstOrNew([
                    'blind_index' => self::blindIndex($fphone),
                ]);
        
        return $test->id ?? 0;
    }
    
    private function get_Student_User_Id($old_id) : int
    {
        return DB::table('people')
                ->select('user_id')
                ->where('old_id', $old_id)
                ->value('user_id');
    }
    
    private function link_Address(array $seed, $user_id)
    {
       
        DB::table('addresses')->insert([
            'user_id' => $user_id,
            'address_01' => $seed['address_01'],
            'address_02' => $seed['address_02'],
            'city' => $seed['city'],
            'geo_state_id' => self::calc_Geo_State_Id($seed['geo_state_abbr']),
            'postal_code' => $seed['postal_code'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
    
    private function link_Instrumentation_Student(array $seed, $user_id)
    {
        $student = \App\Student::find($user_id);
        $instrumentation = \App\Instrumentation::firstWhere(
                'descr', strtolower($seed['voice_part'])
                );
        
        $student->instrumentations()->attach($instrumentation->id);
    }
    
    /**
     * One parent may have many students
     * 
     * ONLY process parents with a first and last name
     * 
     * @param array $seed
     * @param type $student_user_id
     */
    private function link_Parent(array $seed, $student_user_id)
    {
        if(strlen($seed['pg_first_name']) && 
            strlen($seed['pg_last_name'])){
            
            $parent_user = User::create(
                [
                   'name' =>  self::createUserName($seed['pg_first_name'],$seed['pg_last_name']),
                   'password' => password_hash('Password1!', PASSWORD_DEFAULT)
                ]);

            $parent_person = Person::create([
                    'user_id' => $parent_user->id,
                    'old_id' => 0,
                    'last_name' => $seed['pg_last_name'],
                    'first_name' => $seed['pg_first_name'],
                    'middle_name' => $seed['pg_middle_name'],
                    'pronoun_id' => 1, //she
                    'honorific_id' => 1, //Ms.
                ]);

            //CREATE NEW PARENTGUARDIAN OBJECT
            $parentguardian = \App\Parentguardian::create([
                    'user_id' => $parent_person->user_id,
                    'parentguardiantype_id' => $seed['parentguardiantype_id'],
                ]);

            /** LINK PARENT TO STUDENT */
            $parentguardian->students()
                    ->attach($student_user_id, ['parentguardiantype_id' => 1]);

            /** EMAILS: PRIMARY */
            $primary = (self::find_Email($seed['pg_email_primary']))
                    ? \App\Email::find(self::find_Email($seed['pg_email_primary']))
                    : self::build_Email($seed['pg_email_primary']);

            /** EMAILS: ALTERNATE */
            $alternate = (self::find_Email($seed['pg_email_alternate']))
                    ? \App\Email::find(self::find_Email($seed['pg_email_alternate']))
                    : self::build_Email($seed['pg_email_alternate']);

            /** LINK EMAILS */
            $parent_person->emails()->sync([
                $primary->id => ['type' => 'primary'],
                $alternate->id => ['type' => 'alternate']
            ]);

            /** PHONES: HOME */
            $home = (self::find_Phone($seed['pg_phone_home']))
                    ? \App\Phone::find(self::find_Phone($seed['pg_phone_home']))
                    : self::build_Phone($seed['pg_phone_home']);

            /** PHONES: MOBILE */
            $mobile = (self::find_Phone($seed['pg_phone_mobile']))
                    ? \App\Phone::find(self::find_Phone($seed['pg_phone_mobile']))
                    : self::build_Phone($seed['pg_phone_mobile']);

            /** PHONES: WORK */
            $work = (self::find_Phone($seed['pg_phone_work']))
                    ? \App\Phone::find(self::find_Phone($seed['pg_phone_work']))
                    : self::build_Phone($seed['pg_phone_work']);

            /** LINK PHONES */
            $parent_person->phones()->sync([
                $home->id => ['type' => 'home'],
                $mobile->id => ['type' => 'mobile'],
                $work->id => ['type' => 'work'],
            ]);
        }
        
    }
    
    private function link_School_Student(array $seed, $user_id)
    {
        for($i=1; $i<4; $i++){ //school_id_1, school_id_2, school_id_3
        
            $ndx = 'school_id_'.$i;
            
            if(strlen($seed[$ndx]) && ctype_digit($seed[$ndx])){

                DB::table('school_student')->insert([
                    'school_id' => $seed[$ndx],
                    'student_user_id' => $user_id,
                    'statustype_id' => 7, //uploaded
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
    
    private function link_School_Teacher(array $seed, $user_id)
    {
        for($i=1; $i<4; $i++){ //school_id_1, school_id_2, school_id_3
        
            $ndx = 'school_id_'.$i;
            
            if(strlen($seed[$ndx]) && ctype_digit($seed[$ndx])){
                
                $teacher = \App\Teacher::find($user_id);
                
                if(! $teacher->schools->contains([
                    'id' => $seed[$ndx],
                    ])){
                        DB::table('school_teacher')->insert([
                            'school_id' => $seed[$ndx],
                             'teacher_user_id' => $user_id,
                             'start_year' => 1960,
                             'created_at' => Carbon::now(),
                             'updated_at' => Carbon::now(),
                        ]);
                    }
            }
        }
    }
    
    private function link_Student_Teacher(array $seed, $user_id)
    {
        for($i=1; $i<4; $i++){ //director_id_1, director_id_2, director_id_3
        
            $ndx = 'director_id_'.$i;
            
            if(strlen($seed[$ndx]) &&
                ctype_digit($seed[$ndx]) &&
                ($seed[$ndx] > 0)
                ){
                
                    $teacher_id = DB::table('people')
                        ->select('user_id')
                        ->where('old_id', '=', $seed[$ndx])
                        ->value('user_id') 
                            ?? 0;
                    
                    if(!$teacher_id){error_log('No teacher found for old_id='.$seed[$ndx]);}
                    
                    DB::table('student_teacher')->insert([
                        'student_user_id'  => $user_id,
                        'teacher_user_id' => $teacher_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                     ]);
                
            }
            
         }
    }
    
    private function run_Organizations()
    {
        $org_people = [
            [9,1,],
            [9,82,],
            [9,119,],
            [9,124,],
            [9,126,],
            [9,226,],
            [9,130,],
            [9,2121,],
            [9,218,],
            [9,229,],
            [9,251,],
            [9,6686,],
            [9,275,],
            [9,304,],
            [9,309,],
            [9,432,],
            [9,167,],
            [9,370,],
            [9,390,],
            [9,414,],
            [9,420,],
        ];
        
        foreach($org_people AS $o_p){
            DB::table('organization_person')->insert([
                        'organization_id'  => $o_p[0],
                        'user_id' => $o_p[1],
                        'authorized' => 1,
                        'created_at' => Carbon::now(),
                     ]);
        }
    }
    
    private function run_Parents()
    {
        foreach($this->seeds AS $seed){
            
             if(array_key_exists('class_of', $seed)){
            
                 self::link_Parent($seed, self::get_Student_User_Id($seed['old_id']));
             }
        }
    }
    
    /**
     * @since 2020.01.20
     */
    private function run_People($user_id, array $seed)
    {
        $honorific_id = (array_key_exists('honorific_id', $seed))
                ? $seed['honorific_id'] : 1; //Ms.
        
        /** PERSON */
        $person = Person::create([
            'user_id' => $user_id,
            'old_id' => $seed['old_id'],
            'last_name' => $seed['last_name'],
            'first_name' => $seed['first_name'],
            'middle_name' => $seed['middle_name'],
            'pronoun_id' => $seed['pronoun_id'],
            'honorific_id' => $honorific_id,
        ]);
        
        /** EMAILS: PRIMARY */
        $primary = Email::firstOrCreate([
           'email' => $seed['email_primary'],
            'blind_index' => self::blindIndex($seed['email_primary']),
        ]);
        
        /** EMAILS: ALTERNATE */
        $alternate = Email::firstOrCreate([
           'email' => $seed['email_alternate'],
            'blind_index' => self::blindIndex($seed['email_alternate']),
        ]);
        
        /** EMAILS: PIVOT */
        $person->emails()->sync([
            $primary->id => ['type' => 'primary'],
            $alternate->id => ['type' => 'alternate']
        ]);
         
        //PERSON: PHONES: MOBILE
        $mphone = self::FormatPhone($seed['phone_mobile']);  

        $mobile = Phone::firstOrCreate([
            'phone' => $mphone,
            'blind_index' => self::BlindIndex($mphone),
                ]);           
        
        //PERSON: PHONES: HOME
        $hphone = self::FormatPhone($seed['phone_home']);  

        $home = Phone::firstOrCreate([
            'phone' => $hphone,
            'blind_index' => self::BlindIndex($hphone),
                ]);           
   
        //PERSON: PHONES: WORK
        $wphone = self::FormatPhone($seed['phone_work']);  

        $work = Phone::firstOrCreate([
            'phone' => $wphone,
            'blind_index' => self::BlindIndex($wphone),
                ]);           
   
        //PHONE PIVOT TABLES
        $person->phones()->sync([
            $mobile->id => ['type' => 'mobile'],
            $home->id => ['type' => 'home'],
            $work->id => ['type' => 'work'],
        ]);  
        
    }
    
    /**
     * @since 2020.01.16
     * 
     * @param int $user_id
     * @param array $seed
     */
    private function run_Student($user_id, array $seed)
    {
        if(array_key_exists('class_of', $seed)){
            
            DB::table('students')->insert([
                'user_id' => $user_id,
                'class_of' => $seed['class_of'],
                'height' => $seed['height'],
                'birthday' => $seed['birthday'],
                'shirt_size' => $seed['shirt_size'],
                'updated_by' => -1,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
            
            self::link_School_Student($seed, $user_id);
            
            self::link_Student_Teacher($seed, $user_id);
            
            self::link_Address($seed, $user_id);
            
            self::link_Instrumentation_Student($seed, $user_id);
            
        }else{ //$seed is a director row; link directors to schools
            
            $teacher = \App\Teacher::create(['user_id' => $user_id]);
            
            self::link_School_Teacher($seed, $user_id);
        }
    }
    
    /**
     * @since 2020.02.18
     * 
     * @param int $user_id
     * @param array $seed
     */
    private function run_Teacher($user_id, array $seed)
    {
        if(! array_key_exists('class_of', $seed)){
            
            DB::table('teachers')->insert([
                'user_id' => $user_id 
            ]);
            
            for($i=1; $i<4; $i++){
                if(strlen($seed['school_id_'.$i])){
                    
                    DB::table('school_teacher')->insert([
                      'teacher_user_id' => $user_id,
                      'school_id' => $seed['school_id_'.$i]
                    ]);
                }
            }
            
        }
    }
    
    /**
     * @since 2020.01.16
     * 
     * @param int $id
     * @param array $seed
     */
    private function run_User($id, array $seed)
    {
        DB::table('users')->insert([
                'id' => $id,
                'name' => self::createUserName($seed['first_name'],$seed['last_name']),
                'password' => password_hash('Password1!', PASSWORD_DEFAULT)
            ]);
            
    }
}
