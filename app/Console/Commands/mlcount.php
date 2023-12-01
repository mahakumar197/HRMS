<?php

namespace App\Console\Commands;

use App\Models\LeaveEntitlement;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class mlcount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ml:count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ml Count for PL ';

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
        try{

        $now = Carbon::now()->addDays(2);
         
         $user = User::where('gender','=','Female')         
         ->where(function($q) use($now){
                 $q->where('ml_to_date','>=',$now)->where('ml_from_date','<=',$now);
         })        
         ->select('id','name','ml_from_date','ml_to_date')->where('employee_status','=','1')->orderBy('joining_date','ASC')->get();

      
         
        foreach($user as $u){

           
        
      Log::info($u->name);

     // $now = Carbon::now();
 

         $emp = LeaveEntitlement::where('user_id','=',$u->id)->where('leave_type_id','=','6')->get();

               

         if($emp->isEmpty()){
            
            $ml_count = new LeaveEntitlement();

            $ml_count->entitlement = 1;

            

            $ml_count->user_id = $u->id;

             

            $ml_count->year = $now->year;
            $ml_count->leave_type_id = 6;

            $ml_count->save();

            
         }else{

            foreach($emp as $e){
                $e->entitlement = $e->entitlement + 1;
    
                $e->update();
    
               // echo $e->entitlement;
              }
         }

         Log::info('Success Message');


        //Log::info($emp);

     }

    } catch (Exception $e) {


        Log::info($e->getMessage());
    }

    }


    
}
