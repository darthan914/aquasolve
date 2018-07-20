<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukCategory extends Model
{
    protected $table = 'produkcategory';

    protected $fillable = ['name', 'slug', 'flug_publish'];
}
