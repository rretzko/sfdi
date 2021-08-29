<?php

namespace App;

use App\Filecontenttype;
use Illuminate\Database\Eloquent\Model;

class Fileupload extends Model
{
    protected $fillable = ['approved', 'approved_by', 'filecontenttype_id', 'folder_id',
        'registrant_id', 'server_id', 'uploaded_by'];

    public function getFilecontenttypeDescrAttribute()
    {
        return Filecontenttype::find($this->filecontenttype_id)->descr;
    }
}
