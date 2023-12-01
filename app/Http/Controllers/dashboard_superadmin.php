<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnnouncementModel;
use App\Models\attendance;
use App\Models\Job;
use App\Models\LeaveApplication;
use App\Models\LeaveApplicationSummary;
use App\Models\LeaveEntitlement;
use App\Models\LeaveType;
use App\Models\Projectmaster;
use App\Models\TeamAllocations;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class dashboard_superadmin extends Controller
{
    //
    public function index()
    {
        $announcement = AnnouncementModel::where('status', '=', '1')->orderBy('created_at', 'desc')->take(5)->get();
        $id = Auth::id();
        $today = now();
        $current_month = $today->month;

        $project = TeamAllocations::where('user_id', $id)->where('status', '=', '1')->where('end_date', '>=', $today)->with('project')->orderBy('end_date', 'asc')->get();
        $user = User::where('id', $id)->with('designation')->get();
        $employee = User::select('id')->get();

        $total_employee = count($employee);
        $total_leaves = LeaveApplication::whereDate('startDate', '<=', $today)->whereDate('endDate', '>=', $today)->where('leaveStatus', '=', '1')->select('user_id')->get('user_id')->toArray();
        $total_leave = array_column($total_leaves, 'user_id');
        $total_leave_unique = array_unique($total_leave);
        $total_leave_count = count($total_leave_unique);

        $leaves_approved = LeaveApplication::select('user_id')->whereDate('startDate', '<=', $today)->whereDate('endDate', '>=', $today)->where('leaveStatus', '=', '1')->get('user_id')->toArray();
        $total_approved_leave = array_column($leaves_approved, 'user_id');
        $total_approved_leave_unique = array_unique($total_approved_leave);
        $total_approved_leave_count = count($total_approved_leave_unique);

        $leaves_pending = LeaveApplication::select('user_id')->whereDate('startDate', '<=', $today)->whereDate('endDate', '>=', $today)->where('leaveStatus', '=', '0')->get('user_id')->toArray();
        $total_pending_leave = array_column($leaves_pending, 'user_id');
        $total_pending_leave_unique = array_unique($total_pending_leave);
        $total_pending_leave_count = count($total_pending_leave_unique);


        $leaves_emp_morethan_ten_days = LeaveApplication::where('noOfDayDeduct', '>=', '10')->whereMonth('startDate', '<=', $today)->whereMonth('endDate', '>=', $today)->where('leaveStatus', '=', '1')->get('user_id')->toArray();
        $leaves_emp_five_nine_days = LeaveApplication::where('noOfDayDeduct', '>', '5')->where('noOfDayDeduct', '<=', '9')->whereMonth('startDate', '<=', $today)->whereMonth('endDate', '>=', $today)->where('leaveStatus', '=', '1')->get('user_id')->toArray();
        $leaves_emp_two_five_days = LeaveApplication::where('noOfDayDeduct', '>=', '2')->where('noOfDayDeduct', '<=', '5')->whereMonth('startDate', '<=', $today)->whereMonth('endDate', '>=', $today)->where('leaveStatus', '=', '1')->get('user_id')->toArray();
        $leaves_single_days = LeaveApplication::where('noOfDayDeduct', '<=', '1')->whereMonth('startDate', '<=', $today)->whereMonth('endDate', '>=', $today)->where('leaveStatus', '=', '1')->get('user_id')->toArray();

        $tot_emp = User::where('employee_status', '=', '1')->select('id')->count();
        //single day
        $detuct = array_column($leaves_single_days, 'user_id');
        $unique = array_unique($detuct);
        $single_day = count($unique);
        $single_day_percent = round($single_day / $tot_emp * 100);
        //2 to 5 days
        $detuct_two_five_days = array_column($leaves_emp_two_five_days, 'user_id');
        $unique_two_five_days = array_unique($detuct_two_five_days);
        $two_five_days = count($unique_two_five_days);
        $two_five_days_percent = round($two_five_days / $tot_emp * 100);
        //5 to 9 days
        $detuct_five_nine_days = array_column($leaves_emp_five_nine_days, 'user_id');
        $unique_five_nine_days = array_unique($detuct_five_nine_days);
        $five_nine_days = count($unique_five_nine_days);
        $five_nine_days_percent = round($five_nine_days / $tot_emp * 100);
        //more than 10 days
        $detuct_morethan_ten_days = array_column($leaves_emp_morethan_ten_days, 'user_id');
        $unique_morethan_ten_days = array_unique($detuct_morethan_ten_days);
        $morethan_ten_days = count($unique_morethan_ten_days);
        $morethan_ten_days_percent = round($morethan_ten_days / $tot_emp * 100);

        //Projectwise Leave Report

        $emp_leave = array();
        $project_lists = Projectmaster::where('status', '=', '1')->select('id', 'project_name')->get();
        foreach ($project_lists as $pro) {

            $emp_leave[$pro->id] = LeaveApplication::whereHas('user', function ($user) use ($pro, $today) {
                $user->whereHas('team', function ($team) use ($pro, $today) {
                    $team->where('project_id', $pro->id)->where('is_primary_project', '=', 'yes')->where('end_date', '>=', $today);
                });
            })
                ->whereDate('startDate', '<=', $today)->whereDate('endDate', '>=', $today)
                ->where('leaveStatus', '<=', '1')->select('user_id')->get();
        }


        /*upcoming birthday for 7 days | $birthday= User::birthDayBetween(Carbon::now(), Carbon::now()->addWeek())->with('team')->get();*/

        $birthday = User::whereMonth('birth_date', $today->month)->whereDay('birth_date', $today->day)->with('team')->where('employee_status','=','1')->get();
        $joining_date = User::whereBetween('joining_date', array(Carbon::now()->subDays(30)->toDateTimeString(), Carbon::now()->toDateTimeString()))
            ->with('team', function ($team) {
                $team->with('project')->select('user_id', 'project_id');
            })
            ->select('name','last_name', 'designation_id', 'image_path', 'res_city', 'skill_set', 'experience', 'previous_employer', 'hobbies', 'id','joining_date')->where('employee_status', '=', '1')->get();
        

        //-----------------------------Leave Details---------------------------------//
        $user1 = Auth::user();
        $joinDate = Auth::user()->joining_date;
        $now = Carbon::now();
        $currentYear = Carbon::now()->year;
        $leaveTypes = LeaveType::all();
        $allEntitlements = LeaveEntitlement::leftjoin('leave_types', 'leave_types.id', '=', 'leave_entitlements.leave_type_id')
            ->where('user_id', '=', $user1->id)
            ->select(['leave_types.name as leaveType', 'year', 'leave_types.id as leaveTypeId', 'leave_entitlements.id', 'year', 'entitlement'])
            ->get();

        $all_leave_applications = LeaveApplication::where('user_id', '=', $user1->id)
            ->whereYear('startDate', Carbon::now()->format('Y'))
            ->where('leaveStatus', '=', '1')
            ->select(['leave_type_id', 'noOfDayDeduct', 'startDate', 'endDate'])
            ->get();

        $pending_leave_applications = LeaveApplication::whereYear('startDate', Carbon::now()->format('Y'))
            ->where('user_id', '=', $user1->id)
            ->where('leaveStatus', '=', '0')
            ->select(['leave_type_id', 'noOfDayDeduct', 'startDate', 'endDate'])
            ->get();

        $entitlements = collect();
        foreach ($leaveTypes as $leaveType) {
            if ($leaveType->id != 6) {
                $thisYearEntitlement = $allEntitlements
                    ->where('year', '=', $currentYear)
                    ->where('leaveTypeId', '=', $leaveType->id)
                    ->first();


                $thisYearApplicationSum = $all_leave_applications
                    ->where('leave_type_id', '=', $leaveType->id)

                    ->sum('noOfDayDeduct');

                //dd($thisYearApplicationSum);
                $thisYearApplicationSum_pending = $pending_leave_applications
                    ->where('leave_type_id', '=', $leaveType->id)
                    ->sum('noOfDayDeduct');

                if ($thisYearEntitlement != null) {
                    $item = new LeaveApplicationSummary;
                    $item->leaveType = $thisYearEntitlement->leaveType;
                    $item->entitlement = $thisYearEntitlement->entitlement;
                    if ($thisYearEntitlement->entitlement - $thisYearApplicationSum < 0) {
                        $item->balance = 0;
                    } else {
                        $item->balance = $thisYearEntitlement->entitlement - $thisYearApplicationSum;
                    }
                    if ($thisYearApplicationSum_pending != 0) {
                        $item->pending = $thisYearApplicationSum_pending;
                    } else {
                        $item->pending = 0;
                    }
                    $item->used = $thisYearApplicationSum;
                    $entitlements->add($item);
                }
            }
        }

        //-------------------- Reporting to -----------------------//

        $current_primary_project_id = TeamAllocations::where('user_id', Auth::user()->id)->where('is_primary_project', '=', 'yes')
            ->whereDate('start_date', '<=', $today)->whereDate('end_date', '>=', $today)->select('project_id')->first();

        if ($current_primary_project_id != null) {



            $reporting_to = Projectmaster::with('userteam')->where('id', $current_primary_project_id->project_id)->select('user_id', 'id')->first();
        } else {

            $reporting_to = "-";
        }


        //--------Project Wise emp section------------------//

        $project_list = Projectmaster::where('status', '=', '1')->select('id', 'project_name')->get();

        $emp_data = array();
        $emp_attendance = array();
        $emp_not_in_leave = array();
        $emp_attend = array();
        $emp_leave = array();
        $emp_leave_pending = array();
        $current_month = $today->month;

        if ($project_list->isNotEmpty()) {

            foreach ($project_list as $pro) {

                $emp_data[$pro->id] = TeamAllocations::with('user')->where('status', '=', '1')->where('end_date', '>=', $today)
                    ->where('project_id', $pro->id)->whereHas('user', function ($user) {
                        $user->where('role', '!=', 'super_admin');
                    })->get();


                $emp_attendance[$pro->id] = attendance::with('finduser')->whereHas('finduser', function ($user) use ($pro, $today) {
                    $user->whereHas('team', function ($team) use ($pro, $today) {
                        $team->where('project_id', $pro->id)->where('end_date', '>=', $today);
                    })->where('role', '!=', 'super_admin');
                })->whereDate('attendance_date', $today)->select('user_id')->get();

                $emp_leave[$pro->id] = LeaveApplication::with('user')->whereHas('user', function ($user) use ($pro, $today) {
                    $user->whereHas('team', function ($team) use ($pro, $today) {
                        $team->where('project_id', $pro->id)->where('end_date', '>=', $today);
                    })->where('role', '!=', 'super_admin');
                })
                    ->whereDate('startDate', '<=', $today)->whereDate('endDate', '>=', $today)
                    ->where('leaveStatus', '<=', '1')->select('user_id')->get();


                $emp_not_in_leave[$pro->id] = $emp_data[$pro->id]->whereNotIn('user_id', $emp_leave[$pro->id]->pluck('user_id')->toArray());
                $emp_attend[$pro->id] = $emp_data[$pro->id]->whereNotIn('user_id', $emp_attendance[$pro->id]->pluck('user_id')->toArray());
                $emp_not_logged_attendance[$pro->id] = $emp_not_in_leave[$pro->id]->whereIn('user_id', $emp_attend[$pro->id]->pluck('user_id')->toArray());




                $emp_leave_pending[$pro->id] = LeaveApplication::whereHas('user', function ($user) use ($pro, $today) {
                    $user->whereHas('team', function ($team) use ($pro, $today) {
                        $team->where('project_id', $pro->id)->where('end_date', '>=', $today);
                    })->where('role', '!=', 'super_admin');
                })
                    ->whereMonth('startDate', '<=', $current_month)->whereMonth('endDate', '>=', $current_month)
                    ->where('leaveStatus', '<=', '1')->select('user_id')->get();
            }
        } else {

            $emp_not_logged_attendance = 0;
        }


/*---------------------New Job Hiring------------------------*/

        $jobs= Job::where('job_status', '=', '1')->where('created_at','<=',$today)
        ->with(['position'=>function($p){
            $p->select('id','position_name');
        }])
        ->select('id','position_id','job_posted_date','job_status','job_code','headcount')->orderBy('created_at', 'desc')->take(5)->get();
        
        $jobs->isNotEmpty()?$jobs:$jobs="-";

        return view('dashboards.super_admin', compact(
            'entitlements',
            'announcement',
            'single_day',
            'single_day_percent',
            'two_five_days',
            'two_five_days_percent',
            'five_nine_days',
            'five_nine_days_percent',
            'morethan_ten_days',
            'morethan_ten_days_percent',
            'project',
            'user',
            'birthday',
            'joining_date',
            'current_primary_project_id',
            'total_employee',
            'total_leave_count',
            'total_approved_leave_count',
            'total_pending_leave_count',
            'project_lists',
            'emp_leave',
            'project_list',
            'emp_data',
            'emp_attendance',
            'emp_leave',
            'emp_not_logged_attendance',
            'emp_leave_pending',
            'reporting_to','jobs'
        ));
    }
}
