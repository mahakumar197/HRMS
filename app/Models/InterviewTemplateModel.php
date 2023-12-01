<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterviewTemplateModel extends Model
{
    use HasFactory;

    protected $table = 'interview_template';
    protected $fillable = [

        'position_id',
        'round_1',
        'round_2',
        'round_3',
        'round_4',
        'round_5',
        'round_6',
        'round_7',
        'round_8',
        'round_9',
        'round_10',

    ];

    protected $guarded = ['id'];

    public function position()
    {
        return $this->belongsTo(JobPosition::class, 'position_id');
    }
}
