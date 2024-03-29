<?php

namespace App;

use App\School;
use App\MemberType;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'username',
        'password',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Return Registrant object based on user's registration record for $eventversion
     * @param Eventversion $eventversion
     * @return \App\Registrant
     */
    public function currentRegistrant(Eventversion $eventversion): Registrant
    {
        return Registrant::where('eventversion_id', $eventversion->id)
            ->where('user_id', $this->id)
            ->where('registranttype_id', Registranttype::REGISTERED)
            ->first();
    }

    /**
     * Return School object based on user's registration record for $eventversion
     * @param Eventversion $eventversion
     * @return \App\School
     */
    public function currentSchool(Eventversion $eventversion): School
    {
        return School::find($this->currentRegistrant($eventversion)->school_id);
    }

    public function instrumentations()
    {
        return $this->belongsToMany(Instrumentation::class)
            ->withPivot(['order_by']);
    }

    public function isAccepted(Eventversion $eventversion) : bool
    {
        $not_accepteds = ['inc','na','n/a','pend'];

        $registrant = Registrant::where('user_id', $this->id)
            ->where('eventversion_id', $eventversion->id)
            ->where('registranttype_id', Registranttype::REGISTERED)
            ->first();

        return (! $registrant)
            ? false
            : (! in_array(Scoresummary::where('registrant_id', $registrant->id)->first()->result, $not_accepteds));
    }

    public function isStudent() : bool
    {
        return (bool)Student::find($this->id);
    }

    /**
     * Member_Types that belong to $this
     */
    public function member_Types()
    {
        return $this->belongsToMany(MemberType::class);
    }

    public function person()
    {
        return $this->hasOne(Person::class);
    }

    /**
     * School_User is a many-to-many relationship
     */
    public function schools()
    {
        return $this->belongsToMany(School::class,'school_user','user_id', 'school_id');
        //return $this->belongsToMany(School::class,'school_student','school_id', 'student_user_id');
    }

    public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }


}
