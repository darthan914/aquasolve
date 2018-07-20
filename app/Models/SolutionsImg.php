<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolutionsImg extends Model
{
    protected $table = 'solution_img';
    protected $fillable = ['picture', 'category', 'flug_publish'];

    public function solutionsCategory()
    {
      return $this->belongsTo('App\Models\SolutionsCategory', 'category');
    }
}
