<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    use HasFactory;
    protected $fillable = ['position_name'];
    protected $table = 'job_positions';
    protected $guarded = ['id'];    
}
