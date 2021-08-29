<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Missive extends Model
{
    public $encrypted;
    public $person;
    public $school;
    public $statustype_id;
    public $student;
    public $template;
    public $type;

    protected $fillable = [
        'excerpt',
        'header',
        'missive',
        'sent_by_user_id',
        'sent_to',
        'sent_to_user_id',
        'statustype_id'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->encrypted = '**encrypted value**';
        $this->person = NULL;
        $this->school = NULL;
        $this->sent_to = 'primary';
        $this->statustype_id = 1; //alert
        $this->student = NULL;
        $this->template = '';
        $this->type = 'primary'; //default
    }

    /**
     * build missive body
     */
    public function add()
    {
        if(strlen($this->template) &&
                method_exists($this, $this->template)){

            $method = $this->template;
            self::$method();

        }else{ //default

            $this->sent_to_user_id = $this->person->user_id;
            $this->sent_by_user_id = -1; //system generated
            $this->header = 'Default';
            $this->excerpt = 'Default excerpt';
            $this->missive = 'Default missive';
        }
    }

    public function getSentByUserNameAttribute() : string
    {
        return ($this->sent_by_user_id > 0)
            ? App\Person::find($this->sent_by_user_id)->value('fullName')
            : 'system generated';
    }

    public function getStatusDescrAttribute() : string
    {
        return DB::table('statustypes')
                ->select('descr')
                ->where('id', $this->statustype_id)
                ->value('descr');
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'user_id', 'sent_to_user_id');
    }

    /**
     * Return all missives in descending date order (newest first)
     * LIFO = Last In, First Out
     */
    public function scopeLIFO($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function statustype()
    {
        return $this->hasOne(Statustype::class);
    }

/** END OF PUBLIC FUNCTIONS ***************************************************/

    private function sendEmailTeacherAboutNewStudent()
    {
        $student_name = $this->student->fullName;

        $this->sent_to_user_id = $this->person->user_id;
        $this->sent_by_user_id = -1; //system generated
        $this->header = self::truncateHeader($student_name.' added new School '
                . 'or Teacher');
        $this->excerpt = $student_name.' added your school';
        $this->missive ="<p>Hi ".$this->person->first."!</p>";
        $this->missive .= "<p>".$student_name." has asked to be added "
                . "to your Student Roster at ".$this->school->name.".</p>";
        $this->missive .= '<p>'.$student_name.'\'s basic profile '
                . 'is as follows:<br />'
                . '<ul>'
                . '<li>Name: '.$student_name.'</li>'
                . '<li>Class Of: '.$this->student->class_of
                    . ' (Grade '.$this->student->gradeClassOf.')</li>'
                . '</ul>';
        $this->missive .= '<p>'.$student_name.'\'s complete record is '
                . 'available from your Student Roster.</p>';
        $this->missive .= '<p>Please click here to verify that '
                . $student_name.' is your student.</p>';
        $this->missive .= '<p>Otherwise, click here to remove '.$student_name
                . ' from your Student Roster.</p>';
        $this->missive .= "<p>Best -"
                . "<br />Rick Retzko"
                . "<br />Founder, TheDirectorsRooms.com</p>";

    }

    private function sendEmailVerificationNotification()
    {
        $email_type = 'email'.ucfirst($this->type);
        $this->sent_to_user_id = $this->person->user_id;
        $this->sent_by_user_id = -1; //system generated
        $this->header = self::truncateHeader($this->person->$email_type.' Email Verification');
        $this->excerpt = 'Verify '.$this->sent_to.' email: '.$this->encrypted.'.';
        $this->missive ="<p>Welcome to StudentFolder.info, "
                .$this->person->fullName.'!</p>';
        $this->missive .= "<p>Please LOG OUT of StudentFolder.info prior to "
                . "clicking the link below.</p>";
        $this->missive .= "<p>Please click the link to verify that your "
                . $this->type." email is ".$this->person->$email_type.".</p>";
        $this->missive .= ($this->type === 'primary')
                ? '<p>Note: No further emails can be sent until this '
                . 'email is verified!</p>'
                : '';
        $this->missive .= "<p>Thank you for registering with "
                . "StudentFolder.info!</p>";
        $this->missive .= "<p>Best -"
                . "<br />Rick Retzko"
                . "<br />Founder, StudentFolder.info</p>";
    }

    private function sendNewRegistrationEmail()
    {
        $this->sent_to_user_id = $this->person->user_id;
        $this->sent_by_user_id = -1; //system generated
        $this->header = self::truncateHeader('Welcome Email Verification');
        $this->excerpt = 'Welcome email and primary email verification.';
        $this->missive ="Welcome to StudentFolder.info, "
                .$this->person->fullName.'!';
        $this->missive .= '<p>If you have not done so already, we recommend
            that you start by entering all relevant information on the Profile
            page!  Please note: For your safety and confidentiality, we ensure
            that your personally identifiable data (names, home address, emails,
            password) are stored in an encrypted format.</p>';
        $this->missive .= '<p>Further, your information is only shared with the
            teachers and parent/guardians you identify, and with the event
            administrators for those events in which you choose to participate.
            </p>';
        $this->missive .= '<p>If you are currently logged into
            StudentFolder.info, please <b>log out</b>. Once logged out,
            click this link to verify your primary email: '.$this->encrypted.'.</p>';

        $this->missive .= '<p>You can then re-log in using your
            <b>'.$this->person->user->name.'</b> user name and Password.</p>';

        $this->missive .= '<p><u>Note: No further emails can be sent until this
            email is verified!</u></p>';
        $this->missive .= "<p>Thank you for registering with "
                . "StudentFolder.info!</p>";
        $this->missive .= "<p>Best -"
                . "<br />Rick Retzko"
                . "<br />Founder, StudentFolder.info</p>";
    }

    private function sendParentAttachedEmail()
    {
        $user = \App\User::find($this->student->user_id);

        $this->sent_to_user_id = $this->student->user_id;
        $this->sent_by_user_id = -1; //system generated
        $this->header = self::truncateHeader('Parent/Guardian Notification');
        $this->excerpt = 'Notify '.$this->person->fullName.' of '.
                $this->student->person->fullName.'\'s registration.';
        $this->missive = '<p>[NOTE: Email sent to: '
                .$this->person->emailPrimary.'.]<p>';
        $this->missive .= "<p>Welcome to StudentFolder.info, "
                .$this->person->fullName.'!</p>';
        $this->missive .= "<p>You are receiving this email because your child, "
                . $this->student->person->fullName." has registered with "
                . '<a href="'.url('').'">StudentFolder.info</a>.</p>';
        $this->missive .= '<p>StudentFolder.info is a site utilized by students of '
                . 'teachers who are active in group musical events such as '
                . 'All-State and Region Band, Chorus and Orchestras.</p>';
        $this->missive .= '<p>In accordance with '
                . '<a href="https://www.ftc.gov/enforcement/statutes/childrens-online-privacy-protection-act">COPPA</a> '
                . 'regulations, we want to make you aware of your child\'s '
                . 'registration on our site.</p>';
        $this->missive .= '<p>Your child\'s personally identifiable information '
                . 'is stored in encrypted format for their privacy and '
                . 'protection.  Further, that information is ONLY shared with '
                . 'the child\'s teacher(s) and the administrators for any '
                . 'events in which they register.  Typically, administrators will '
                . 'use this information to monitor attendance, maintain '
                . 'discipline and to ensure proper spelling in published '
                . 'programs.</p>';
        $this->missive .= '<p>You may access this site yourself by using your '
                . 'child\'s user name (<b>'.$user->name.'</b>) and their '
                . 'self-set password.  We do not have access to your child\'s '
                . 'password.</p>';
        $this->missive .= '<p>If you would wish to limit the use your child\'s '
                . 'information, please contact their teacher(s).  Teacher names '
                . 'can be found on the site by logging in and then clicking the '
                . '"Schools" link.</p>';
        $this->missive .= "<p>Best -"
                . "<br />Rick Retzko"
                . "<br />Founder, StudentFolder.info</p>";
    }

    private function sendPasswordResetEmail()
    {
        $this->sent_to_user_id = $this->person->user_id;
        $this->sent_by_user_id = -1; //system generated
        $this->header = self::truncateHeader('Password Reset Notification');
        $this->excerpt = 'Password reset for '.$this->person->fullName.'.';
        $this->missive = '<p>Hi, '.$this->person->first_name.'!<p>';
        $this->missive .= "<p>You are receiving this email because we received
            a password reset request for your account at StudentFolder.info</p>";
        $this->missive .= "<p>**Reset Password Button**</p>";
        $this->missive .= "<p>The password reset link will expire in 60 minutes.</p>";
        $this->missive .= "<p>If you did not request a password reset, no further
            action is required.</p>";
        $this->missive .= "<p>Best -"
                . "<br />Rick Retzko"
                . "<br />Founder, StudentFolder.info</p>";
    }

    /**
     * Ensure that header is never more than 24-characters long
     * else return elipse-suffixed 21-character string
     */
    private function truncateHeader($str) : string
    {
        return (strlen($str) <= 24) ? $str : (substr($str, 0, 21).'...');
    }
}
