<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Parentguardian extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'user_id';
    public $fillable = [
        'user_id',
        'parentguardiantype_id',
        ];
    public $incrementing = false;

    public function parentguardianType_Description($student_id) : string
    {
        return DB::table('parentguardiantypes')
                ->select('descr')
                ->where([
                        ['id', self::parentguardiantype_Id($student_id)],
                    ])
                ->value('descr') ?? 'none found';
    }

    public function parentguardiantype_Id($student_id) : int
    {
        return DB::table('parentguardian_student')
                ->select('parentguardiantype_id')
                ->where([
                    ['parentguardian_user_id', $this->user_id],
                    ['student_user_id', $student_id]
                ])
                ->value('parentguardiantype_id') ?? 1; //default to mother
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'user_id');
    }

    public function students()
    {
        return $this->belongsToMany(
                Student::class, 'parentguardian_student',
                'parentguardian_user_id', 'student_user_id')
                ->withPivot('parentguardiantype_id');
    }
/** END OF PUBLIC FUNCTIONS ***************************************************/

}
