<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrQuestionnaire extends Model
{
    use HasFactory;
    protected $fillable = [
        'can_id', 'job_id', 'comments', '	looking_out_change_in_job', 'tot_exp',
        'relevant_exp', 'current_ctc', 'expected_ctc', 'why_look_for_job_change', 'other_offer_in_pipeline',
        'native_place','medical_issues','marital_status',];
    protected $table = 'hr_questionnaire';
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
