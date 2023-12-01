<?php

namespace App\Console\Commands;

use App\Models\LeaveEntitlement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Exception;

class privilegeleave extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'privilegeleave:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Previlege Leave';

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
 
           Log::info('Pl Updated -test2');

try{
      
        $to = now()->subYear()->year;

       
        $user = User::whereYear('joining_date','<=',$to)->where('employee_status','=','1')->select('id','joining_date')->get();

        foreach($user as $u){

            $emp = LeaveEntitlement::where('user_id','=',$u->id)->where('leave_type_id','=','2')->get();

            $ml_count = LeaveEntitlement::where('user_id','=',$u->id)->where('leave_type_id','=','6')->select('entitlement')->first();
            
          
 
            $month = Carbon::parse($u->joining_date)->format('m');

            $month_count = $month - 1 ;
            $jyear = Carbon::parse($u->joining_date)->format('Y');
            $year = Carbon::today()->format('Y');

             $rem_month = 12 - $month_count ;
  
   
             foreach($emp as $e){

                if($jyear == $to ){

                   

                    if($ml_count == null) {

                       

                $e->entitlement = ((12/12)*$rem_month);
                $e->entitlement = round($e->entitlement) ;

               
                
                    }else{

                        

                        $e->entitlement = ((12/12)*$rem_month)-$ml_count->entitlement;
                        $e->entitlement = round($e->entitlement) ;

                        

                    }
            
                }else{
                    
                     
                    if($ml_count == null) {
                        
                    
                        $e->entitlement = 12;

                    }else{
                    
                        
                        $e->entitlement = 12-$ml_count->entitlement;

                    }



                    
                }

              

                $e->year = $year;

                 $e->update();

                 //Log::info($e->entitlement);
             }
             

        }
        
    } catch (Exception $e) {


        Log::info($e->getMessage());
    }
        
     

    }
}
