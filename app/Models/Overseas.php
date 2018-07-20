<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overseas extends Model
{
    protected $table = 'overseas';

    protected $fillable = ['name','img_url', 'flug_publish'];
}
