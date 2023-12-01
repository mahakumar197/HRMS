<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechFeedbackModel extends Model
{
    use HasFactory;

    protected $table = 'tech_feedback';
    protected $guarded = ['id'];  
    protected $fillable = ['can_id','job_id','round','overall_comment','schedule_id','can_image'];
    protected $casts = ['skill_detail' => 'array'];


     public function candetails()
    {
        return $this->belongsTo(Candidate::class,'can_id');
    }


    public function jobdetails()
    {
        return $this->belongsTo(Job::class,'job_id');
    }

}
