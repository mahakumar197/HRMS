<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobScheduleModel extends Model
{
    use HasFactory;

    protected $fillable = ['job_id','interviewer_id','can_id','schedule_date','schedule_time','interview_type','meeting_link','round_name',
                            'job_interview_id'];

    
    protected $table = 'job_schedule';
    protected $guarded = ['id'];



     public function candetails()
    {
        return $this->belongsTo(Candidate::class,'can_id');
    }

    public function jobdetails()
    {
        return $this->belongsTo(Job::class,'job_id');
    }

    public function interviewer(){
        return $this->belongsTo(User::class,'interviewer_2_id');
    }

    public function jobinterview()
    {
        return $this->belongsTo(JobInterview::class,'job_interview_id');
    }

    public function rounddetails()
    {

        return $this->belongsTo(InterviewRound::class,'round_id');
    }

    public function employee()
    {

        return $this->belongsTo(User::class,'interviewer_id');
    }


}
