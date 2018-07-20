<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolutionsCategory extends Model
{
    protected $table = 'solutioncategory';
    protected $fillable = ['name', 'flug_publish'];
}
