<?php

namespace App;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;

class Nonsubscriberemail extends Model
{
    use Encryptable;

    protected $encryptable = ['email'];
    protected $fillable = ['email', 'emailtype_id', 'user_id'];

    /**
     * Return array of user objects for all users found with $email address
     * @param $email
     * @return array
     */
    public function getUserFromEmail($email) : array
    {
        $users = [];

        foreach($this::all() AS $indb){

            if(strtolower($indb->email) === strtolower($email)){

                $users[] = User::with(['person','person.student'])->where('id', $indb->user_id)->first();
            }
        }

        return $users;
    }
}
