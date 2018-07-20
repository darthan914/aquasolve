<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Careers extends Model
{
    protected $table = 'careers';
    protected $fillable = ['name', 'job_type', 'location', 'contract', 'vacancy', 'job_description', 'responsibilities', 'qualifications', 'flug_publish'];
}
