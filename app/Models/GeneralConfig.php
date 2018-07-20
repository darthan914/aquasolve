<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralConfig extends Model
{
    protected $table = 'general_config';
    protected $fillable = ['name', 'title', 'content', 'picture', 'description', 'flug_publish'];
}
