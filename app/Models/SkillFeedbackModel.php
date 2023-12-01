<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillFeedbackModel extends Model
{
    use HasFactory;

    protected $table = 'skill_feedback';
    protected $guarded = ['id'];  
    protected $fillable = ['can_id','job_id','skill_id','current_round','comment','rating'];



    public function skillname()
    {
        return $this->belongsTo(SkillSet::class,'skill_id');
    }
}
