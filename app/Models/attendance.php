<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';
    protected $casts = [ 'secondary_project' => 'array' ,  'primary_project' => 'array'  ];
    protected $fillable = ['attendance_date','total_working_hours','day_count'];
    





    public function teamatten(){


        return $this->belongsTo(TeamAllocations::class);
       }



       Public function finduser(){

        return $this->belongsTo(User::class,'user_id');

      }
}
