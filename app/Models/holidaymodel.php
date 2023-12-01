<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class holidaymodel extends Model
{
    use HasFactory;

    protected $fillable = ['holidayname','holidaydate','holidaytype','holidayscope','holidaystatus','fullDay'];
    protected $table = 'holidaymodels';
    protected $guarded = ['id'];
}
