<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registranttype extends Model
{
    const ELIGIBLE = 14;
    const HIDDEN = 17;
    const NOAPP = 24;
    const REGISTERED = 16;
}
