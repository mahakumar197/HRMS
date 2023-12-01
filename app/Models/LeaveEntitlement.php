<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveEntitlement extends Model
{
    use HasFactory;
    
    Public function user(){

        return $this->belongsTo(User::class);

    }

    Public function leaveType(){
        return $this->belongsTo(LeaveType::class);
    }

}
