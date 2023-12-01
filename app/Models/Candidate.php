<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $table = 'candidates';

    protected $fillable = [
        'name', 'email_id', 'job_id', 'current_position', 'current_company', 'candidate_location', 'phone_number', 'alternate_phone_number', 'gender', 'total_experience',
        'relevant_experience', 'notice_period', 'current_ctc', 'expected_ctc', 'graduation_degree', 'graduation_university', 'nationality', 'language_known', 'address', 'candidate_created_date', 'outsourced_via',
        'recruiter_name',  'resume_upload', 'candidate_negotiation_salary', 'skills'
    ];

    protected $guarded = ['id'];

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
    public function employee()
    {
        return $this->belongsTo(User::class,'recruiter_name');
    }

    public function consultancy_details()
    {
        return $this->belongsTo(Agency::class, 'consultancy_id');
    }
}
