<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillSet extends Model
{
    use HasFactory;
    protected $fillable = ['skillset'];
    protected $table = 'skillsets';
    protected $guarded = ['id'];  
}
