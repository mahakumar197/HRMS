<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\designation;

use App\Models\Projectmaster;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'employee_code',
        'middle_name',              
        'last_name',
        'designation',             
        'joining_date',               
        'birth_date',             
        'gender',                  
        'marital_status',        
        'phone_number' ,
        'emergency_contact',
        'reporting_to',               
        'res_address',               
        'res_city',                 
        'per_address',               
        'res_state',                  
        'per_city',                   
        'res_postal_code',            
        'per_state' ,                 
        'nationality',                
        'per_postal_code' ,         
        'dependency_name' ,          
        'dependency',              
        'higest_qualification',
        'employee_status',           
        'aadhar_number',              
        'pan_number',                 
        'experience',        
        'skill_set',
        'exit_date',
        'maternity_leave',
        'ml_from_date',
        'ml_to_date',
        'password_change_at',
        'last_login_time',   
       ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function designation()
    {
        return $this->belongsTo(designation::class);   
    
    } 
    
    
     public function  team(){

        return $this->hasMany(TeamAllocations::class,'user_id');
     }


     public function jobpivot(){

        return $this->belongsToMany(Job::class, 'jobs_users','users_id', 'jobs_id')->withPivot('ack');
     }
      
    
}
