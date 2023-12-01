<?php

namespace App\Console\Commands;

use App\Models\LeaveEntitlement;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class causalleavesecond extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'causalleave:second';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Causal Leave for second 6 months';

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
       /** 
        *$user = User::select('id')->get();

       * foreach($user as $u){

        * $emp = LeaveEntitlement::where('user_id','=',$u->id)->where('leave_type_id','=','1')->get();


        * foreach($emp as $e){
         *   $e->entitlement = $e->entitlement + 3;
 
        *    $e->update();

         *  // echo $e->entitlement;
       *  }



    * } 
    */

    try{
        Log::info('runned');

        $user = User::select('id')->get();
        foreach($user as $u){

            $emp = LeaveEntitlement::where('user_id','=',$u->id)->where('leave_type_id','=',' ')->get();

              foreach($emp as $e){
                  $e->entitlement = 0;
        
                    $e->update();
       
               
                 }
        }
        
         } catch (Exception $e) {

        Log::info($e->getMessage());
    }

    }
}
