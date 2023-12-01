<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewRound extends Model
{
    use HasFactory;
    protected $fillable = ['round_name','feedback_template'];
    protected $table = 'interview_rounds';
    protected $guarded = ['id'];  
}
