<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonInterviewFeedback extends Model
{
    use HasFactory;
    protected $fillable = ['can_id','job_id','round','overall_comment','interviewer','schedule_id','can_image'];
    protected $table = 'common_feedback';
    protected $guarded = ['id'];


    
     public function candetails()
    {
        return $this->belongsTo(Candidate::class,'can_id');
    }


    public function jobdetails()
    {
        return $this->belongsTo(Job::class,'job_id');
    }

    
}
