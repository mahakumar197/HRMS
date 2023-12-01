<?php

namespace App\Services;

use App\Student;

use App\Models\attendance;
use App\Models\LeaveApplication;
use App\Models\LeaveEntitlement;
use App\Models\TeamAllocations;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * Class AttendanceService
 * @package App\Services
 */
class leave_record_service
{
    /**
     * @return mixed
     */



    public function getcl($v_employee_id=null,$from_month=null,$to_month=null,$v_employee_name=null,$v_employee_last_name=null,$v_employee_joining_date=null,$v_employee_employee_code=null,$relieved_employee=null,$year=null,$to_year=null)
    {


        $leave_cl = LeaveApplication::whereMonth('startDate', '>=', $from_month)->whereYear('startDate', '>=', $year)->where('user_id',$v_employee_id)
        ->whereMonth('endDate', '<=', $to_month)->whereYear('endDate', '<=', $to_year)->where('leave_type_id','=','1')->where('leaveStatus','=','1')->select('noOfDayDeduct')->sum('noOfDayDeduct');

        $leave_pl = LeaveApplication::whereMonth('startDate', '>=', $from_month)->whereYear('startDate', '>=', $year)->where('user_id',$v_employee_id)
        ->whereMonth('endDate', '<=', $to_month)->whereYear('endDate', '<=', $to_year)->where('leave_type_id','=','2')->where('leaveStatus','=','1')->select('noOfDayDeduct')->sum('noOfDayDeduct');

        $leave_sl = LeaveApplication::whereMonth('startDate', '>=', $from_month)->whereYear('startDate', '>=', $year)->where('user_id',$v_employee_id)
        ->whereMonth('endDate', '<=', $to_month)->whereYear('endDate', '<=', $to_year)->where('leave_type_id','=','3')->where('leaveStatus','=','1')->select('noOfDayDeduct')->sum('noOfDayDeduct');

        $leave_cl_ent = LeaveEntitlement::where('user_id',$v_employee_id)->where('leave_type_id','=','1')->select('entitlement','id','user_id')->first();
        $leave_sl_ent = LeaveEntitlement::where('user_id',$v_employee_id)->where('leave_type_id','=','3')->select('entitlement')->first('entitlement');
        $leave_pl_ent = LeaveEntitlement::where('user_id',$v_employee_id)->where('leave_type_id','=','2')->select('entitlement')->first('entitlement');

       if($relieved_employee->isNotEmpty()) {
 

        foreach($relieved_employee as $re){
            $relieved ='';
            $exit_date = '';
        if($re->id == $v_employee_id ){

            $relieved= 'yes';
            $exit_date = $re->exit_date;
            break;

        }

       }
    }else{

        $relieved = null;
        $exit_date = null;

    }
       
 

 //Log::info($leave_cl_ent->user_id);
 
        $result1= array();
        $result1=[

            'CL'=>$leave_cl,
            'SL'=>$leave_sl,
            'PL'=>$leave_pl,
            'name'=>$v_employee_name,
            'last_name'=>$v_employee_last_name,
            'code'=>$v_employee_employee_code,
            'joining_date'=>$v_employee_joining_date,
            'cl_ent' => $leave_cl_ent->entitlement,
            'sl_ent' => $leave_sl_ent->entitlement,
            'pl_ent' => $leave_pl_ent->entitlement,
            'relieved' => $relieved,
            'exit_date' => $exit_date,
            'id'    => $v_employee_id,
        ];




        return $result1;

    }




}
