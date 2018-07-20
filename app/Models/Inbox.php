<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{
    protected $table = 'inbox';
    protected $fillable = ['name', 'email', 'subyek', 'message', 'flag_read'];
}