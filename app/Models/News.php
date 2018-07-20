<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';

    protected $fillable = ['name', 'descript', 'picture', 'slug', 'flug_publish'];
}
