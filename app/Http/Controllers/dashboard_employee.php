<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnnouncementModel;
use App\Models\Job;
use App\Models\LeaveApplication;
use App\Models\LeaveApplicationSummary;
use App\Models\LeaveEntitlement;
use App\Models\LeaveType;
use App\Models\Projectmaster;
use App\Models\TeamAllocations;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class dashboard_employee extends Controller
{
    public function index()
    {
        $announcement = AnnouncementModel::where('status', '=', '1')->orderBy('created_at', 'desc')->take(5)->get();
        $id = Auth::id();
        $today = now();
        $project = TeamAllocations::where('user_id', $id)->where('status', '=', '1')->where('end_date', '>=', $today)->with('project')->orderBy('end_date', 'asc')->get();
        $user = User::where('id', $id)->with('designation')->get();

        /*upcoming birthday for 7 days | $birthday= User::birthDayBetween(Carbon::now(), Carbon::now()->addWeek())->with('team')->get();*/

        $birthday = User::whereMonth('birth_date', $today->month)->whereDay('birth_date', $today->day)->with('team')->where('employee_status', '=', '1')->get();
        $joining_date = User::whereBetween('joining_date', array(Carbon::now()->subDays(30)->toDateTimeString(), Carbon::now()->toDateTimeString()))
            ->with('team', function ($team) {
                $team->with('project')->select('user_id', 'project_id');
            })->select('name', 'last_name','designation_id', 'image_path', 'res_city', 'skill_set', 'experience', 'previous_employer', 'hobbies', 'id','joining_date')->where('employee_status', '=', '1')->get();


        $user1 = Auth::user();
        $joinDate = $user1->joining_date;
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

        /*---------------------New Job Hiring------------------------*/

        $jobs = Job::where('job_status', '=', '1')->where('emp_show','=','1')->where('created_at', '<=', $today->addDays(7))
            ->with(['position' => function ($p) {
                $p->select('id', 'position_name');
            }])
            ->select('id','position_id', 'job_posted_date', 'job_status', 'job_code', 'headcount')->orderBy('created_at', 'desc')->take(5)->get();
        $jobs->isNotEmpty() ? $jobs : $jobs = "";


        return view('dashboards.employee', compact(
            'announcement',
            'project',
            'user',
            'birthday',
            'joining_date',
            'entitlements',
            'user1',
            'reporting_to',
            'current_primary_project_id',
            'jobs'
        ));
        
       
    }
}
