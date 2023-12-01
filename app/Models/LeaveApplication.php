<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    use HasFactory;

    protected $table = 'leave_applications';

    protected $fillable = [
        'startDate',
        'endDate',
        'name',
        'fullDay',
        'user_id',
        'leave_type_id',
        'noOfDayApplied',
        'noOfWorkingDay',
        'noOfPublicHoliday',
        'noOfDayDeduct',
        'leaveStatus',
        'needCertificate', 
        'leaveReason',
        'assignedBy',
        'remarks',   
    ];

    Public function user(){

        return $this->belongsTo(User::class,'user_id');

    }

    Public function leaveType(){
        return $this->belongsTo(LeaveType::class,'leave_type_id');
    }


}
