<?php

namespace App\Http\Controllers;

use App\Models\LeaveApplication;
use App\Models\LeaveApplicationSummary;
use App\Models\LeaveEntitlement;
use App\Models\LeaveType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveBalanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $emp = User::get();
        $joinDate = $user->joining_date;
        $now = Carbon::now()->format('Y-m-d');
        $currentYear = Carbon::now()->year;
        $leaveTypes = LeaveType::all();

        $allEntitlements = LeaveEntitlement::leftjoin('leave_types', 'leave_types.id', '=', 'leave_entitlements.leave_type_id')
            ->where('user_id', '=', $user->id)
            ->select(['leave_types.name as leaveType', 'year', 'leave_types.id as leaveTypeId', 'leave_entitlements.id', 'year', 'entitlement'])
            ->get();


        $all_leave_applications = LeaveApplication::where('user_id', '=', $user->id)
            ->whereYear('startDate', Carbon::now()->format('Y'))
            ->where('leaveStatus', '=', '1')
            ->select(['leave_type_id', 'noOfDayDeduct', 'startDate', 'endDate'])
            ->get();

        $pending_leave_applications = LeaveApplication::whereYear('startDate', Carbon::now()->format('Y'))
            ->where('user_id', '=', $user->id)
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


        $leave_details_emp =  LeaveApplication::where('user_id', $user->id)->get();


        return view('leave.leavebalance', compact('leave_details_emp', 'leaveType', 'entitlements', 'user', 'now', 'emp'));
    }
}
