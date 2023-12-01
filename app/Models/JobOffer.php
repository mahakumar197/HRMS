<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory;
    protected $table = 'job_offer';

    protected $fillable = [
        'can_id',
        'job_id',
        'document verified',
        'dv_comment',
        'dv_date',
        'offer_letter',
        'ol_comment',
        'ol_date',
        'offer_ack',
        'offer_ack_comment',
        'offer_ack_date',
        'joining_date',
        'appointment_order_received',
        'aor_date',
        'ol_updated_by',
        'dv_updated_by',
        'ack_updated_by',
        'aor_updated_by'
    ];
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
