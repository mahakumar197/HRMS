<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

 



class TeamAllocations extends Model
{
    use HasFactory;

      Protected $table = 'team_allocations';

      Protected $fillable = ['user_id','project_id','project_type','work_type','billable','shadow_eligible','start_date','end_date','unit_rate','status'];
      

      Public function user(){

        return $this->belongsTo(User::class);

      }

      public function project(){


       return $this->belongsTo(Projectmaster::class);
      }
    


      

}
