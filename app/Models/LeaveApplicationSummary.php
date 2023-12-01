<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApplicationSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'leaveType',
        'entitlement',        
        'used',
        'balance',
    ];
}
