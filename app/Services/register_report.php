<?php

namespace App\Services;

use App\Student;

use App\Models\attendance;
use App\Models\LeaveApplication;
use App\Models\TeamAllocations;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;

use Carbon\Carbon;


/**
 * Class AttendanceService
 * @package App\Services
 */
class  register_report
{
  /**
   * @return mixed
   */
  public function getAttendances($v_employee_id = null, $sdate = null, $flag = null,  $ml_from_date=null, $ml_to_date=null,$month = null )
  {
         
    
    if($ml_from_date != null && Carbon::parse($sdate) ->greaterThanOrEqualTo(Carbon::parse($ml_from_date)) && $ml_to_date != null && Carbon::parse($sdate) ->lessThanOrEqualTo(Carbon::parse($ml_to_date)) ){
          
      $result1 = array();
      $result1 = ['attendance_date' => $sdate, 'day_count' => 0.0, 'user_id' => $v_employee_id, 'attendance_status' => 'ML'];

      return $result1;
    }
     
     
    $leave_exist = array();

    $result1 = attendance::where('user_id', $v_employee_id)->where('attendance_date', $sdate)->where('total_working_hours','>=','8')->select('day_count', 'attendance_date', 'user_id','total_working_hours','work_from')->get()->toArray();
  //dd($result1);
     

    if (count($result1) != 0) {


      $collection = array();

      foreach ($result1 as $key => $value) {

        $collection['day_count'] = $value['day_count'];
        $collection['user_id'] = $value['user_id'];
        $collection['attendance_date'] = $value['attendance_date'];
        $collection['work_from']  = $value['work_from'];
      }
      $new = collect($collection);
      $result = $new->put('attendance_status', 'p');
      $result1 = $result->toArray();
    }
    



    if (count($result1) == 0 && $flag != 'HOL') {

      $leave_exist = LeaveApplication::with('leaveType')->where('user_id', $v_employee_id)->whereDate('startDate', '<=', $sdate)->whereDate('endDate', '>=', $sdate)
                     ->where('leaveStatus', '<=', '1')->where('noOfDayDeduct', '>=', '0.5')->select('noOfDayDeduct', 'startDate', 'leave_type_id')->get();

      $collection = array();

      foreach ($leave_exist as $key => $value) {

        $collection['noOfDayDeduct'] = $value['noOfDayDeduct'];
        $collection['attendance_status'] = $value['leaveType']['name'];
      }
      $new = collect($collection);
      // $result = $new->put('attendance_status','l');
      $result1 = $new->toArray();

      //dd($result1);



    }

    if (count($leave_exist) == 0 && count($result1) == 0) {

      $result1 = array();
      $result1 = ['attendance_date' => $sdate, 'day_count' => 0.0, 'user_id' => $v_employee_id, 'attendance_status' => $flag];
    }



    return $result1;
  }


  public function getweekend($v_employee_id = null, $sdate = null)
  {

    $result1 = array();
    $result1 = ['attendance_date' => $sdate, 'day_count' => 0.0, 'user_id' => $v_employee_id, 'attendance_status' => 'WKND'];

    return $result1;
  }


  public function getempty($v_employee_id = null, $sdate = null)
  {

    $result1 = array();
    $result1 = ['attendance_date' => $sdate, 'day_count' => 0.0, 'user_id' => $v_employee_id, 'attendance_status' => 'empty'];

    return $result1;
  }


  public function getleave($v_employee_id, $month)
  {

    $leave_cl = LeaveApplication::whereMonth('startDate', '=', $month)->where('user_id', $v_employee_id)
      ->whereMonth('endDate', '=', $month)->where('leave_type_id', '=', '1')->where('leaveStatus', '=', '1')->select('noOfDayDeduct')->sum('noOfDayDeduct');



    //  $sum = array_sum($leave_cl);

    // dd($leave_cl);
    return $leave_cl;
  }


  public function getpl($v_employee_id, $month)
  {

    $leave_pl = LeaveApplication::whereMonth('startDate', '=', $month)->where('user_id', $v_employee_id)
      ->whereMonth('endDate', '=', $month)->where('leave_type_id', '=', '2')->where('leaveStatus', '=', '1')->select('noOfDayDeduct')->sum('noOfDayDeduct');



    //  $sum = array_sum($leave_cl);

    //dd($leave_cl);
    return $leave_pl;
  }


  public function getrate($v_employee_id)
  {

    $unit_rate = TeamAllocations::where('user_id', $v_employee_id)->where('is_primary_project', '=', 'yes')
      ->where('status', '=', '1')->select('unit_rate')->value('unit_rate');






    //dd($unit_rate);

    //  $sum = array_sum($leave_cl);

    // dd($leave_cl);
    return $unit_rate;
  }
}
