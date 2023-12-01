<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AttendanceContoller;
use App\Http\Controllers\Controller;
use App\Models\attendance;
use App\Models\holidaymodel;
use App\Models\LeaveApplication;
use App\Models\User;
use App\Models\WeekDay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectAuthenticatedUsersController extends Controller
{
    public function home()
    {
        $today = Carbon::now()->format('Y-m-d');
        $today_attendance = attendance::where('user_id', Auth::user()->id)->where('attendance_date', $today)->pluck('attendance_date');
        $leave_exist = LeaveApplication::where('user_id', Auth::user()->id)->whereDate('startDate', '<=', $today)
            ->whereDate('endDate', '>=', $today)->where('leaveStatus', '<=', '1')->where('noOfDayDeduct', '>=', '1')
            ->select('startDate', 'endDate', 'leaveStatus')->get('startDate', 'endDate');

        $holiday_exist = holidaymodel::where('holidaydate', $today)->where('holidaystatus','=',1)->whereYear('holidaydate',Carbon::now()->year)->select('id')->get();
        $ml_exists = User::where('id','=',Auth::user()->id)->where('gender','=','Female')
        ->where('ml_from_date','<=',$today)->where('ml_to_date','>=',$today)       
        ->select('id')->exists();
   
        
        $to = Carbon::now();



        if (auth()->user()->role == 'super_admin' && Auth::user()->employee_status == '1') {
            if (Auth::user()->password_change_at == null) {
                return redirect('password_change');
            }elseif($ml_exists == 'true'){
                return redirect('superadmin');
            } 
            elseif (count($today_attendance) == 0) {
                
                if (count($leave_exist) == 0 && count($holiday_exist) == 0 && $to->englishDayOfWeek != 'Sunday' &&  $to->englishDayOfWeek != 'Saturday') {

                    return redirect('attendance/create');
                }
            }
            
            return redirect('superadmin');

            //Project Manager//

        } elseif (auth()->user()->role == 'project_manager' && Auth::user()->employee_status == '1') {

            if (Auth::user()->password_change_at == null) {
                return redirect('password_change');
            } 
            elseif($ml_exists == 'true'){
                return redirect('projectmanager');
            } 
            elseif (count($today_attendance) == 0) {

                if (count($leave_exist) == 0 && count($holiday_exist) == 0 && $to->englishDayOfWeek != 'Sunday' &&  $to->englishDayOfWeek != 'Saturday') {

                    return redirect('attendance/create');
                }
            }
           
            return redirect('projectmanager');


            //Employee//
            
        } elseif (auth()->user()->role == 'employee' && Auth::user()->employee_status == '1') {
            if (Auth::user()->password_change_at == null) {
                return redirect('password_change');
            }elseif($ml_exists == 'true'){
                return redirect('employeedashboard');
            } 
             elseif (count($today_attendance) == 0) {

                if (count($leave_exist) == 0 && count($holiday_exist) == 0 && $to->englishDayOfWeek != 'Sunday' &&  $to->englishDayOfWeek != 'Saturday') {

                    return redirect('attendance/create');
                }
            }

            return redirect('employeedashboard');
        } else {

            Auth::logout();
            return redirect()->route('login');
        }
    }
}
