<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'partner';

    protected $fillable = ['name','img_url','img_alt','flag_buynow','link_url','tanggal_post','flag_publish'];
}
