<?php

namespace App;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Model;

class Nonsubscriberemail extends Model
{
    use Encryptable;

    protected $encryptable = ['email'];
    protected $fillable = ['email', 'emailtype_id', 'user_id'];
}
