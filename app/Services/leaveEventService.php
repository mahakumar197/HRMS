<?php

namespace App\Services;

use App\Mail\leaveadmin;
use App\Models\TeamAllocations;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\notifyuser;
use Carbon\Carbon;

class leaveEventService
{


     public function mailevent($user){

       
       
        $user_id = $user['emp_id'];
       

        $today=Carbon::now();
        
        $pm_search= TeamAllocations::where('user_id',$user_id)->where('is_primary_project','=','yes')->with(['project'=>function($project){
                $project->select('id','user_id')->get();
        }])->whereDate('start_date', '<=', $today)->whereDate('end_date', '>=', $today)->select('id','project_id')->get()->first();
        
        $pm_id = $pm_search->project->user_id;
        $pm = User::where('id',$pm_id)->select('email')->first();

        $pm_email = $pm->email;
        
         
         
       //  event(new leaveadmin($pm_email, $user));

       Mail::to($pm_email)->send(new leaveadmin($user));

       
     }
}