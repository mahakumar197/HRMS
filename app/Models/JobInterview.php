<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobInterview extends Model
{
    use HasFactory;
    protected $table = 'job_interview';
    protected $fillable = [

        'can_id',
        'job_id',
        'round_1',
        'round_1_img',
        'round_1_feedback',
        'round_1_feedback_type',
        'round_1_status',
        'round_2',
        'round_2_img',
        'round_2_feedback',
        'round_2_feedback_type',
        'round_2_status',
        'round_3',
        'round_3_img',
        'round_3_feedback',
        'round_3_feedback_type',
        'round_3_status',
        'round_4',
        'round_4_img',
        'round_4_feedback',
        'round_4_feedback_type',
        'round_4_status',
        'round_5',
        'round_5_img',
        'round_5_feedback',
        'round_5_feedback_type',
        'round_5_status',
        'round_6',
        'round_6_img',
        'round_6_feedback',
        'round_6_feedback_type',
        'round_6_status',
        'round_7',
        'round_7_img',
        'round_7_feedback',
        'round_7_feedback_type',
        'round_7_status',
        'round_8',
        'round_8_img',
        'round_8_feedback',
        'round_8_feedback_type',
        'round_8_status',
        'round_9',
        'round_10',



    ];

    protected $guarded = ['id'];

    public function position()
    {
        return $this->belongsTo(JobPosition::class, 'position_id');
    }

    public function candetails()
    {
        return $this->belongsTo(Candidate::class,'can_id');
    }

    public function jobdetails()
    {
        return $this->belongsTo(Job::class,'job_id');
    }   
   

    public function roundname1()
    {
        return $this->belongsTo(InterviewRound::class,'round_1');
    }

    public function roundname2()
    {
        return $this->belongsTo(InterviewRound::class,'round_2');
    }
    public function roundname3()
    {
        return $this->belongsTo(InterviewRound::class,'round_3');
    }
    public function roundname4()
    {
        return $this->belongsTo(InterviewRound::class,'round_4');
    }
    public function roundname5()
    {
        return $this->belongsTo(InterviewRound::class,'round_5');
    }
    public function roundname6()
    {
        return $this->belongsTo(InterviewRound::class,'round_6');
    }
    public function roundname7()
    {
        return $this->belongsTo(InterviewRound::class,'round_7');
    }
}
