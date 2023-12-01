<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Job extends Model
{
    use HasFactory;
    protected $fillable = ['job_code,position_id,project_id,canditate_type,location,
                            job_type_id,headcount,minimum_salary,maximum_salary,currency,emp_refer,
                            billing_mode,experience_required,importance,job_posted_date,job_owner,job_description,essential_skills,desirable_skills'];

    protected $casts = ['consultancy_refer' => 'array','essential_skills' =>'array','desirable_skills'=>'array','rounds'=>'array'];
    protected $table = 'jobs';
    protected $guarded = ['id'];

    public function project()
    {

        return $this->belongsTo(Projectmaster::class, 'project_id');
    }
    public function position()
    {

        return $this->belongsTo(JobPosition::class, 'position_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'job_owner');
    }

    public function job_type()
    {

        return $this->belongsTo(JobType::class, 'job_type_id');
    }   

    public function userpivot()
    {

        return $this->belongsToMany(user::class, 'jobs_users', 'jobs_id', 'users_id')->withPivot('ack');
    }

    public function consultancypivot()
    {

        return $this->belongsToMany(Agency::class, 'consultancy_jobs', 'jobs_id', 'consultancy_id')->withPivot('ack');
    }
    
}
