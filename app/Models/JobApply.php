<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApply extends Model
{
    protected $table = 'job_apply';
    protected $fillable = ['name', 'email', 'telp', 'message', 'file','flag_read'];
}
