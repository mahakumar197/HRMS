<?php

namespace App\Services;

use App\Student;

use App\Models\attendance;
use App\Models\LeaveApplication;
use App\Models\TeamAllocations;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;


/**
 * Class AttendanceService
 * @package App\Services
 */
class yearleavereportService
{
  /**
   * @return mixed
   */



  public function getcl($v_employee_id = null, $sdate = null, $year = null, $to_year = null)
  {


    $leave_cl = LeaveApplication::whereMonth('startDate', '=', $sdate)->whereYear('startDate', '>=', $year)->where('user_id', $v_employee_id)
      ->where('leave_type_id', '=', '1')->where('leaveStatus', '=', '1')->select('noOfDayDeduct')->sum('noOfDayDeduct');

    $leave_pl = LeaveApplication::whereMonth('startDate', '=', $sdate)->whereYear('startDate', '>=', $year)->where('user_id', $v_employee_id)
      ->whereMonth('endDate', '=', $sdate)->where('leave_type_id', '=', '2')->where('leaveStatus', '=', '1')->select('noOfDayDeduct')->sum('noOfDayDeduct');

    $leave_sl = LeaveApplication::whereMonth('startDate', '=', $sdate)->whereYear('startDate', '>=', $year)->where('user_id', $v_employee_id)
      ->whereMonth('endDate', '=', $sdate)->where('leave_type_id', '=', '3')->where('leaveStatus', '=', '1')->select('noOfDayDeduct')->sum('noOfDayDeduct');

    $leave_lop = LeaveApplication::whereMonth('startDate', '=', $sdate)->whereYear('startDate', '>=', $year)->where('user_id', $v_employee_id)
      ->whereMonth('endDate', '=', $sdate)->where('leave_type_id', '=', '5')->where('leaveStatus', '=', '1')->select('noOfDayDeduct')->sum('noOfDayDeduct');


    $result1 = array();
    $result1 = ['CL' => $leave_cl, 'SL' => $leave_sl, 'PL' => $leave_pl, 'LOP' => $leave_lop];

    //  $sum = array_sum($leave_cl);

    return $result1;
  }


  public function getpl($v_employee_id, $month)
  {

    $leave_pl = LeaveApplication::whereMonth('startDate', '=', $month)->where('user_id', $v_employee_id)
      ->whereMonth('endDate', '=', $month)->where('leave_type_id', '=', '2')->where('leaveStatus', '=', '1')->select('noOfDayDeduct')->sum('noOfDayDeduct');

    //  $sum = array_sum($leave_cl);

    return $leave_pl;
  }


  public function getsl($v_employee_id, $month)
  {

    $leave_sl = LeaveApplication::whereMonth('startDate', '=', $month)->where('user_id', $v_employee_id)
      ->whereMonth('endDate', '=', $month)->where('leave_type_id', '=', '3')->where('leaveStatus', '=', '1')->select('noOfDayDeduct')->sum('noOfDayDeduct');

    //  $sum = array_sum($leave_cl);
    
    return $leave_sl;
  }


  public function getlop($v_employee_id, $month)
  {

    $leave_lop_count = LeaveApplication::whereMonth('startDate', '=', $month)->where('user_id', $v_employee_id)
      ->whereMonth('endDate', '=', $month)->where('leave_type_id', '=', '5')->where('leaveStatus', '=', '1')->select('noOfDayDeduct')->sum('noOfDayDeduct');

    //  $sum = array_sum($leave_cl);
    
    return $leave_lop_count;
  }


  public function getrate($v_employee_id)
  {

    $unit_rate = TeamAllocations::where('user_id', $v_employee_id)->where('is_primary_project', '=', 'yes')
      ->where('status', '=', '1')->select('unit_rate')->value('unit_rate');   

    //  $sum = array_sum($leave_cl);
  
    return $unit_rate;
  }
}
