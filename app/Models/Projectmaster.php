<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\TeamAllocations;

class Projectmaster extends Model
{
    use HasFactory;

    Protected  $table = 'projectmasters';
    
    Protected  $fillable = ['project_name','user_id','location','start_date','end_date','project_id','billing_mode','currency','created_by'];


     Public function teamassign(){

            return $this->hasMany('App\Models\TeamAllocations','project_id','id');

     }

     Public function userteam(){

       return $this->belongsTo('App\Models\User','user_id','id');

}

     
   
    
}
