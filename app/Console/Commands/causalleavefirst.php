<?php

namespace App\Console\Commands;

use App\Models\LeaveEntitlement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class causalleavefirst extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'causalleave:first';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Causal Leave for first 6 months';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

         $now = Carbon::now();

        
           $user = User::select('id','name','employee_code')->where('employee_status','=','1')->get();

           $ml_user = User::where('gender','=','Female')         
           ->where(function($q) use($now){
                   $q->where('ml_to_date','>=',$now)->where('ml_from_date','<=',$now);
           })        
           ->select('id','name','ml_from_date','ml_to_date')->where('employee_status','=','1')->orderBy('joining_date','ASC')->get();
           
            
  
           foreach($user as $u){
               
                

            if(!$ml_user){

               

            foreach($ml_user as $ml){
 

                if($u->id != $ml->id){

                $emp = LeaveEntitlement::where('user_id','=',$u->id)->where('leave_type_id','=','1')->get();
                
               


            foreach($emp as $e){
               $e->entitlement = $e->entitlement + 1;
 
               $e->update();

              // echo $e->entitlement;
             }

                }else{

                    Log::info($u->employee_code);
                }

                
            }

        }else{

 

            $emp1 = LeaveEntitlement::where('user_id','=',$u->id)->where('leave_type_id','=','1')->get();
                
               


            foreach($emp1 as $e1){
               $e1->entitlement = $e1->entitlement + 1;
 
               $e1->update();

              
             }


        }
           
            
          Log::info($u->id);

            
           //Log::info($emp);

        }


    }
}
