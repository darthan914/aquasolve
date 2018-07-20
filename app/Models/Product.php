<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $fillable = ['name', 'descript', 'picture', 'background_picture', 'website', 'category', 'slug', 'flug_home', 'flug_publish'];

    public function produkCategory()
    {
      return $this->belongsTo('App\Models\ProdukCategory', 'category');
    }
}
