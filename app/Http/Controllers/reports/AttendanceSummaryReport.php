<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\teamallocation;
use App\Models\attendance;
use App\Models\holidaymodel;
use App\Models\LeaveApplication;
use App\Models\Projectmaster;
use App\Models\TeamAllocations;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AttendanceSummaryReport extends Controller
{
    public function attendanceall(Request $request)
    {
        $today = now()->format('Y-m-d');


        if (request()->ajax()) {


            if ($request->attend_from_date != '' && $request->attend_to_date != '') {

                $from_date = Carbon::parse($request->attend_from_date);
                $to_date = Carbon::parse($request->attend_to_date);

                $data = attendance::whereDate('attendance_date', '>=', $from_date)
                    ->whereDate('attendance_date', '<=', $to_date)->get();
                //->orderBy('attendance_date', 'DESC');

                return datatables($data)
                    ->addIndexColumn()

                    ->addColumn('emp_name', function ($post) {
                        $first_name = $post->finduser->name;
                        $last_name = $post->finduser->last_name;
                        $name = $first_name . ' ' . $last_name;
                        return $name;
                    })
                    ->addColumn('emp_code', function ($post) {
                        return $post->finduser->employee_code;
                    })
                    ->addColumn('designation', function ($post) {
                        return $post->finduser->designation->designation;
                    })
                    ->addColumn('primary_project', function ($primary) {
                        $projects = [];
                        foreach ($primary['primary_project'] as $e) {
                            $projects = $e["name"];
                        }
                        return [$projects];
                    })
                    ->addColumn('primary_project_hours', function ($primary_hours) {
                        $hours = [];
                        foreach ($primary_hours['primary_project'] as $e) {
                            $hours = $e["hours"];
                        }
                        return [$hours];
                    })
                    ->addColumn('secondary_project', function ($primary) {
                        $projects = [];
                        foreach ($primary['secondary_project'] as $e) {
                            $projects[] = $e["project"];
                        }
                        return $projects;
                    })
                    ->addColumn('secondary_project_hours', function ($primary_hours) {
                        $hours = [];
                        foreach ($primary_hours['secondary_project'] as $e) {
                            $hours = $e["hours"];
                        }
                        return [$hours];
                    })
                    ->rawColumns(['primary_project', 'primary_project_hours', 'secondary_project', 'secondary_project_hours'])


                    ->make(true);
            }
        }
        return view('report.attendance-summary.superadmin-attendance');
    }


    //----------------- Attendance Summary Report Project Manager -------------------//



    public function attendancepm(Request $request)
    {
        $id = Auth::id();
        $today = now()->format('Y-m-d');


        if (request()->ajax()) {


            if ($request->attend_from_date != '' && $request->attend_to_date != '') {

                $from_date = Carbon::parse($request->attend_from_date);
                $to_date = Carbon::parse($request->attend_to_date);

                $data = attendance::whereHas('finduser', function ($user) use ($id) {
                    $user->whereHas('team', function ($team) use ($id) {
                        $team->whereHas('project', function ($project) use ($id) {
                            $project->where('user_id', $id);
                        })->where('is_primary_project', '=', 'yes');
                    });
                })->whereDate('attendance_date', '>=', $from_date)
                    ->whereDate('attendance_date', '<=', $to_date)->get();
                //->orderBy('attendance_date', 'DESC');



                return datatables($data)->addIndexColumn()

                    ->addColumn('emp_name', function ($post) {
                        $first_name = $post->finduser->name;
                        $last_name = $post->finduser->last_name;
                        $name = $first_name . ' ' . $last_name;
                        return $name;
                    })
                    ->addColumn('emp_code', function ($post) {
                        return $post->finduser->employee_code;
                    })
                    ->addColumn('designation', function ($post) {
                        return $post->finduser->designation->designation;
                    })
                    ->addColumn('primary_project', function ($primary) {
                        $projects = [];
                        foreach ($primary['primary_project'] as $e) {
                            $projects = $e["name"];
                        }
                        return [$projects];
                    })
                    ->addColumn('primary_project_hours', function ($primary_hours) {
                        $hours = [];
                        foreach ($primary_hours['primary_project'] as $e) {
                            $hours = $e["hours"];
                        }
                        return [$hours];
                    })
                    ->addColumn('secondary_project', function ($primary) {
                        $projects = [];
                        foreach ($primary['secondary_project'] as $e) {
                            $projects[] = $e["project"];
                        }
                        return $projects;
                    })
                    ->addColumn('secondary_project_hours', function ($primary_hours) {
                        $hours = [];
                        foreach ($primary_hours['secondary_project'] as $e) {
                            $hours = $e["hours"];
                        }
                        return [$hours];
                    })
                    ->rawColumns(['primary_project', 'primary_project_hours', 'secondary_project', 'secondary_project_hours'])


                    ->make(true);
            }
        }
        return view('report.attendance-summary.attendance-pm');
    }

    //-----------------Attendance Summary Report Employee-------------------//

    public function attendanceemp(Request $request)
    {
        $id = Auth::id();

        if (request()->ajax()) {

            $from_date = Carbon::parse($request->attend_from_date);
            $to_date = Carbon::parse($request->attend_to_date);

            if ($request->attend_from_date != '' && $request->attend_to_date != '') {

                $data = attendance::where('user_id', $id)
                    ->whereDate('attendance_date', '>=', $from_date)
                    ->whereDate('attendance_date', '<=', $to_date)
                    ->orderBy('attendance_date', 'DESC')->get();

                return datatables($data)->addIndexColumn()

                    ->addColumn('emp_name', function ($post) {
                        $first_name = $post->finduser->name;
                        $last_name = $post->finduser->last_name;
                        $name = $first_name . ' ' . $last_name;
                        return $name;
                    })
                    ->addColumn('emp_code', function ($post) {
                        return $post->finduser->employee_code;
                    })
                    ->addColumn('designation', function ($post) {
                        return $post->finduser->designation->designation;
                    })
                    ->addColumn('primary_project', function ($primary) {
                        $projects = [];
                        foreach ($primary['primary_project'] as $e) {
                            $projects = $e["name"];
                        }
                        return [$projects];
                    })
                    ->addColumn('primary_project_hours', function ($primary_hours) {
                        $hours = [];
                        foreach ($primary_hours['primary_project'] as $e) {
                            $hours = $e["hours"];
                        }
                        return [$hours];
                    })
                    ->addColumn('secondary_project', function ($primary) {
                        $projects = [];
                        foreach ($primary['secondary_project'] as $e) {
                            $projects[] = $e["project"];
                        }
                        return $projects;
                    })
                    ->addColumn('secondary_project_hours', function ($primary_hours) {
                        $hours = [];
                        foreach ($primary_hours['secondary_project'] as $e) {
                            $hours = $e["hours"];
                        }
                        return [$hours];
                    })

                    ->make(true);
            }
        }
        return view('report.attendance-summary.employee-attend-report');
    }

    //Employee not marked attendance project wise//

    public function projectWiseAttendanceNotMarked(Request $request)
    {
        if(Auth::user()->role == 'project_manager'){
            $project = Projectmaster::where('user_id',Auth::id())->select('id', 'project_name')->get();
        }
        else{
            $project = Projectmaster::select('id', 'project_name')->get();
        }
        

        if (request()->ajax()) {

            if ($request->project != '') {
                $now = Carbon::today();
                $today = Carbon::today()->startOfYear();
                $feb = Carbon::today()->startOfYear()->addMonth(1);
                $mar = Carbon::today()->startOfYear()->addMonth(2);
                $apr = Carbon::today()->startOfYear()->addMonth(3);
                $may = Carbon::today()->startOfYear()->addMonth(4);
                $jun = Carbon::today()->startOfYear()->addMonth(5);
                $jly = Carbon::today()->startOfYear()->addMonth(6);
                $aug = Carbon::today()->startOfYear()->addMonth(7);
                $sep = Carbon::today()->startOfYear()->addMonth(8);
                $oct = Carbon::today()->startOfYear()->addMonth(9);
                $nov = Carbon::today()->startOfYear()->addMonth(10);
                $dec = Carbon::today()->startOfYear()->addMonth(11);

                $team = TeamAllocations::where('project_id', '=', $request->project)->pluck('user_id')->toArray();
                $data = User::whereIn('id', $team)->where('employee_status', '=', 1)->select('id', 'name','last_name', 'employee_code', 'joining_date');
                //$data = User::where('id', 165)->where('employee_status', '=', 1)->select('id', 'name', 'employee_code','joining_date');

                return datatables($data)->addIndexColumn()

                    ->addColumn('primary_project', function ($post) use ($request) {
                        // $project = Projectmaster::where('id', $request->project)->pluck('project_name')->toArray();
                        $project = Teamallocations::where('user_id', $post->id)->where('status', '=', '1')->where('end_date', '>=', Carbon::now())->with('project')->select('id', 'project_id')->first();
                        return $project->project->project_name;
                    })
                    ->addColumn('name',function($row){
                        $first_name = $row->name;
                        $last_name = $row->last_name;
                        $name = $first_name . ' ' . $last_name;
                        return $name;
                    })
                    ->addColumn('jan', function ($row) use ($today, $now) {

                        if (Carbon::parse($row->joining_date)->format('m') == Carbon::parse($today)->format('m') && Carbon::parse($row->joining_date)->format('Y') == Carbon::parse($today)->format('Y')) {
                            $start =  Carbon::parse($row->joining_date);
                        } else {
                            $start = Carbon::parse($today->firstOfMonth());
                        }
                        $end = Carbon::parse($today->endOfMonth());
                        if ($now->lt($end)) {
                            $end = $now;
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } elseif ($start == Carbon::parse($row->joining_date)) {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } else {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end);
                        }
                        if (Carbon::parse($row->joining_date)->gt($start)) {
                            $not_marked_attendance = '-';
                        } else {


                            if ($start->gt(Carbon::now())) {
                                $not_marked_attendance = '';
                            } else {

                                if ($now->eq($end)) {
                                    $public_holidays = holidaymodel::whereDate('holidaydate', '<=', $end)->whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereDate('startDate', '<=', $end)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                } else {
                                    $public_holidays = holidaymodel::whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                }
                                $attendance_marked_fulday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '>=', 8)->count();
                                $attendance_marked_halfday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '=', 4)->select('total_working_hours')->get();
                                $att_hl_day = 0;
                                if ($attendance_marked_halfday->isNotEmpty()) {
                                    foreach ($attendance_marked_halfday as $halfday) {
                                        $att_hl_day += 0.5;
                                    }
                                }
                            }

                            $leave_count = 0;
                            if ($leave_taken->isNotEmpty()) {
                                foreach ($leave_taken as $lt) {
                                    $leave_count += $lt->noOfDayDeduct;
                                }
                            }
                            $not_marked_attendance = $days - $public_holidays - $attendance_marked_fulday - $att_hl_day - $leave_count;
                        }

                        return $not_marked_attendance;
                    })

                    ->addColumn('feb', function ($row) use ($feb, $now) {
                        if (Carbon::parse($row->joining_date)->format('m') == Carbon::parse($feb)->format('m') && Carbon::parse($row->joining_date)->format('Y') == Carbon::parse($feb)->format('Y')) {
                            $start =  Carbon::parse($row->joining_date);
                        } else {
                            $start = Carbon::parse($feb->firstOfMonth());
                        }
                        $end = Carbon::parse($feb->endOfMonth());
                        if ($now->lt($end)) {
                            $end = $now;
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } elseif ($start == Carbon::parse($row->joining_date)) {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } else {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end);
                        }

                        if (Carbon::parse($row->joining_date)->gt($start)) {
                            $not_marked_attendance = '-';
                        } else {

                            if ($start->gt(Carbon::now())) {
                                $not_marked_attendance = '';
                            } else {

                                if ($now->eq($end)) {
                                    $public_holidays = holidaymodel::whereDate('holidaydate', '<=', $end)->whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereDate('startDate', '<=', $end)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                } else {
                                    $public_holidays = holidaymodel::whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                }
                                $attendance_marked_fulday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '>=', 8)->count();
                                $attendance_marked_halfday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '=', 4)->select('total_working_hours')->get();
                                $att_hl_day = 0;
                                if ($attendance_marked_halfday->isNotEmpty()) {
                                    foreach ($attendance_marked_halfday as $halfday) {
                                        $att_hl_day += 0.5;
                                    }
                                }

                                $leave_count = 0;
                                if ($leave_taken->isNotEmpty()) {
                                    foreach ($leave_taken as $lt) {
                                        $leave_count += $lt->noOfDayDeduct;
                                    }
                                }
                                $not_marked_attendance = $days - $public_holidays - $attendance_marked_fulday - $att_hl_day - $leave_count;
                            }
                        }

                        return $not_marked_attendance;
                    })
                    ->addColumn('mar', function ($row) use ($mar, $now) {
                        if (Carbon::parse($row->joining_date)->format('m') == Carbon::parse($mar)->format('m') && Carbon::parse($row->joining_date)->format('Y') == Carbon::parse($mar)->format('Y')) {
                            $start =  Carbon::parse($row->joining_date);
                        } else {
                            $start = Carbon::parse($mar->firstOfMonth());
                        }
                        $end = Carbon::parse($mar->endOfMonth());
                        if ($now->lt($end)) {
                            $end = $now;
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } elseif ($start == Carbon::parse($row->joining_date)) {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } else {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end);
                        }
                        if (Carbon::parse($row->joining_date)->gt($start)) {
                            $not_marked_attendance = '-';
                        } else {


                            if ($start->gt(Carbon::now())) {
                                $not_marked_attendance = '';
                            } else {

                                if ($now->eq($end)) {
                                    $public_holidays = holidaymodel::whereDate('holidaydate', '<=', $end)->whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereDate('startDate', '<=', $end)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                } else {
                                    $public_holidays = holidaymodel::whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                }
                                $attendance_marked_fulday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '>=', 8)->count();
                                $attendance_marked_halfday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '=', 4)->select('total_working_hours')->get();
                                $att_hl_day = 0;
                                if ($attendance_marked_halfday->isNotEmpty()) {
                                    foreach ($attendance_marked_halfday as $halfday) {
                                        $att_hl_day += 0.5;
                                    }
                                }

                                $leave_count = 0;
                                if ($leave_taken->isNotEmpty()) {
                                    foreach ($leave_taken as $lt) {
                                        $leave_count += $lt->noOfDayDeduct;
                                    }
                                }
                                $not_marked_attendance = $days - $public_holidays - $attendance_marked_fulday - $att_hl_day - $leave_count;
                            }
                        }

                        return $not_marked_attendance;
                    })
                    ->addColumn('apr', function ($row) use ($apr, $now) {
                        if (Carbon::parse($row->joining_date)->format('m') == Carbon::parse($apr)->format('m') && Carbon::parse($row->joining_date)->format('Y') == Carbon::parse($apr)->format('Y')) {
                            $start =  Carbon::parse($row->joining_date);
                        } else {
                            $start = Carbon::parse($apr->firstOfMonth());
                        }
                        $end = Carbon::parse($apr->endOfMonth());
                        if ($now->lt($end)) {
                            $end = $now;
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } elseif ($start == Carbon::parse($row->joining_date)) {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } else {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end);
                        }
                        if (Carbon::parse($row->joining_date)->gt($start)) {
                            $not_marked_attendance = '-';
                        } else {


                            if ($start->gt(Carbon::now())) {
                                $not_marked_attendance = '';
                            } else {

                                if ($now->eq($end)) {
                                    $public_holidays = holidaymodel::whereDate('holidaydate', '<=', $end)->whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereDate('startDate', '<=', $end)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                } else {
                                    $public_holidays = holidaymodel::whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                }
                                $attendance_marked_fulday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '>=', 8)->count();
                                $attendance_marked_halfday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '=', 4)->select('total_working_hours')->get();
                                $att_hl_day = 0;
                                if ($attendance_marked_halfday->isNotEmpty()) {
                                    foreach ($attendance_marked_halfday as $halfday) {
                                        $att_hl_day += 0.5;
                                    }
                                }

                                $leave_count = 0;
                                if ($leave_taken->isNotEmpty()) {
                                    foreach ($leave_taken as $lt) {
                                        $leave_count += $lt->noOfDayDeduct;
                                    }
                                }
                                $not_marked_attendance = $days - $public_holidays - $attendance_marked_fulday - $att_hl_day - $leave_count;
                            }
                        }

                        return $not_marked_attendance;
                    })
                    ->addColumn('may', function ($row) use ($may, $now) {

                        if (Carbon::parse($row->joining_date)->format('m') == Carbon::parse($may)->format('m') && Carbon::parse($row->joining_date)->format('Y') == Carbon::parse($may)->format('Y')) {
                            $start =  Carbon::parse($row->joining_date);
                        } else {
                            $start = Carbon::parse($may->firstOfMonth());
                        }
                        $end = Carbon::parse($may->endOfMonth());
                        if ($now->lt($end)) {
                            $end = $now;
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } elseif ($start == Carbon::parse($row->joining_date)) {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } else {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end);
                        }
                        if (Carbon::parse($row->joining_date)->gt($start)) {
                            $not_marked_attendance = '-';
                        } else {

                            if ($start->gt(Carbon::now())) {
                                $not_marked_attendance = '';
                            } else {

                                if ($now->eq($end)) {
                                    $public_holidays = holidaymodel::whereDate('holidaydate', '<=', $end)->whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereDate('startDate', '<=', $end)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                } else {
                                    $public_holidays = holidaymodel::whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                }
                                $attendance_marked_fulday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '>=', 8)->count();
                                $attendance_marked_halfday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '=', 4)->select('total_working_hours')->get();
                                $att_hl_day = 0;
                                if ($attendance_marked_halfday->isNotEmpty()) {
                                    foreach ($attendance_marked_halfday as $halfday) {
                                        $att_hl_day += 0.5;
                                    }
                                }

                                $leave_count = 0;
                                if ($leave_taken->isNotEmpty()) {
                                    foreach ($leave_taken as $lt) {
                                        $leave_count += $lt->noOfDayDeduct;
                                    }
                                }
                                $not_marked_attendance = $days - $public_holidays - $attendance_marked_fulday - $att_hl_day - $leave_count;
                            }
                        }
                        return $not_marked_attendance;
                    })
                    ->addColumn('jun', function ($row) use ($jun, $now) {

                        if (Carbon::parse($row->joining_date)->format('m') == Carbon::parse($jun)->format('m') && Carbon::parse($row->joining_date)->format('Y') == Carbon::parse($jun)->format('Y')) {
                            $start =  Carbon::parse($row->joining_date);
                        } else {
                            $start = Carbon::parse($jun->firstOfMonth());
                        }
                        $end = Carbon::parse($jun->endOfMonth());
                        if ($now->lt($end)) {
                            $end = $now;
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } elseif ($start == Carbon::parse($row->joining_date)) {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } else {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end);
                        }

                        if (Carbon::parse($row->joining_date)->gt($start)) {
                            $not_marked_attendance = '-';
                        } else {

                            if ($start->gt(Carbon::now())) {
                                $not_marked_attendance = '';
                            } else {
                                if ($now->eq($end)) {
                                    $public_holidays = holidaymodel::whereDate('holidaydate', '<=', $end)->whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereDate('startDate', '<=', $end)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                } else {
                                    $public_holidays = holidaymodel::whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                }
                                $attendance_marked_fulday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '>=', 8)->count();
                                $attendance_marked_halfday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '=', 4)->select('total_working_hours')->get();
                                $att_hl_day = 0;
                                if ($attendance_marked_halfday->isNotEmpty()) {
                                    foreach ($attendance_marked_halfday as $halfday) {
                                        $att_hl_day += 0.5;
                                    }
                                }

                                $leave_count = 0;
                                if ($leave_taken->isNotEmpty()) {
                                    foreach ($leave_taken as $lt) {
                                        $leave_count += $lt->noOfDayDeduct;
                                    }
                                }
                                $not_marked_attendance = $days - $public_holidays - $attendance_marked_fulday - $att_hl_day - $leave_count;
                            }
                        }
                        return $not_marked_attendance;
                    })
                    ->addColumn('jly', function ($row) use ($jly, $now) {

                        if (Carbon::parse($row->joining_date)->format('m') == Carbon::parse($jly)->format('m') && Carbon::parse($row->joining_date)->format('Y') == Carbon::parse($jly)->format('Y')) {
                            $start =  Carbon::parse($row->joining_date);
                        } else {
                            $start = Carbon::parse($jly->firstOfMonth());
                        }
                        $end = Carbon::parse($jly->endOfMonth());
                        if ($now->lt($end)) {
                            $end = $now;
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } elseif ($start == Carbon::parse($row->joining_date)) {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } else {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end);
                        }
                        if (Carbon::parse($row->joining_date)->gt($start)) {
                            $not_marked_attendance = '-';
                        } else {

                            if ($start->gt(Carbon::now())) {
                                $not_marked_attendance = '';
                            } else {

                                if ($now->eq($end)) {
                                    $public_holidays = holidaymodel::whereDate('holidaydate', '<=', $end)->whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereDate('startDate', '<=', $end)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                } else {
                                    $public_holidays = holidaymodel::whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                }
                                $attendance_marked_fulday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '>=', 8)->count();
                                $attendance_marked_halfday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '=', 4)->select('total_working_hours')->get();
                                $att_hl_day = 0;
                                if ($attendance_marked_halfday->isNotEmpty()) {
                                    foreach ($attendance_marked_halfday as $halfday) {
                                        $att_hl_day += 0.5;
                                    }
                                }

                                $leave_count = 0;
                                if ($leave_taken->isNotEmpty()) {
                                    foreach ($leave_taken as $lt) {
                                        $leave_count += $lt->noOfDayDeduct;
                                    }
                                }
                                $not_marked_attendance = $days - $public_holidays - $attendance_marked_fulday - $att_hl_day - $leave_count;
                            }
                        }

                        return $not_marked_attendance;
                    })
                    ->addColumn('aug', function ($row) use ($aug, $now) {
                        if (Carbon::parse($row->joining_date)->format('m') == Carbon::parse($aug)->format('m') && Carbon::parse($row->joining_date)->format('Y') == Carbon::parse($aug)->format('Y')) {
                            $start =  Carbon::parse($row->joining_date);
                        } else {
                            $start = Carbon::parse($aug->firstOfMonth());
                        }
                        $end = Carbon::parse($aug->endOfMonth());
                        if ($now->lt($end)) {
                            $end = $now;
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } elseif ($start == Carbon::parse($row->joining_date)) {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } else {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end);
                        }
                        if (Carbon::parse($row->joining_date)->gt($start)) {
                            $not_marked_attendance = '-';
                        } else {
                            if ($start->gt(Carbon::now())) {
                                $not_marked_attendance = '';
                            } else {

                                if ($now->eq($end)) {
                                    $public_holidays = holidaymodel::whereDate('holidaydate', '<=', $end)->whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereDate('startDate', '<=', $end)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                } else {
                                    $public_holidays = holidaymodel::whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                }
                                $attendance_marked_fulday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '>=', 8)->count();
                                $attendance_marked_halfday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '=', 4)->select('total_working_hours')->get();
                                $att_hl_day = 0;
                                if ($attendance_marked_halfday->isNotEmpty()) {
                                    foreach ($attendance_marked_halfday as $halfday) {
                                        $att_hl_day += 0.5;
                                    }
                                }

                                $leave_count = 0;
                                if ($leave_taken->isNotEmpty()) {
                                    foreach ($leave_taken as $lt) {
                                        $leave_count += $lt->noOfDayDeduct;
                                    }
                                }
                                $not_marked_attendance = $days - $public_holidays - $attendance_marked_fulday - $att_hl_day - $leave_count;
                            }
                        }
                        return $not_marked_attendance;
                    })
                    ->addColumn('sep', function ($row) use ($sep, $now) {
                        if (Carbon::parse($row->joining_date)->format('m') == Carbon::parse($sep)->format('m') && Carbon::parse($row->joining_date)->format('Y') == Carbon::parse($sep)->format('Y')) {
                            $start =  Carbon::parse($row->joining_date);
                        } else {
                            $start = Carbon::parse($sep->firstOfMonth());
                        }
                        $end = Carbon::parse($sep->endOfMonth());
                        if ($now->lt($end)) {
                            $end = $now;
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } elseif ($start == Carbon::parse($row->joining_date)) {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } else {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end);
                        }
                        if (Carbon::parse($row->joining_date)->gt($start)) {
                            $not_marked_attendance = '-';
                        } else {
                            if ($start->gt(Carbon::now())) {
                                $not_marked_attendance = '';
                            } else {

                                if ($now->eq($end)) {
                                    $public_holidays = holidaymodel::whereDate('holidaydate', '<=', $end)->whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereDate('startDate', '<=', $end)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                } else {
                                    $public_holidays = holidaymodel::whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                }

                                $attendance_marked_fulday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '>=', 8)->count();
                                $attendance_marked_halfday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '=', 4)->select('total_working_hours')->get();
                                $att_hl_day = 0;
                                if ($attendance_marked_halfday->isNotEmpty()) {
                                    foreach ($attendance_marked_halfday as $halfday) {
                                        $att_hl_day += 0.5;
                                    }
                                }

                                $leave_count = 0;
                                if ($leave_taken->isNotEmpty()) {
                                    foreach ($leave_taken as $lt) {
                                        $leave_count += $lt->noOfDayDeduct;
                                    }
                                }

                                $not_marked_attendance = $days - $public_holidays - $attendance_marked_fulday - $att_hl_day - $leave_count;
                            }
                        }
                        return $not_marked_attendance;
                    })
                    ->addColumn('oct', function ($row) use ($oct, $now) {
                        if (Carbon::parse($row->joining_date)->format('m') == Carbon::parse($oct)->format('m') && Carbon::parse($row->joining_date)->format('Y') == Carbon::parse($oct)->format('Y')) {
                            $start =  Carbon::parse($row->joining_date);
                        } else {
                            $start = Carbon::parse($oct->firstOfMonth());
                        }
                        $end = Carbon::parse($oct->endOfMonth());
                        if ($now->lt($end)) {
                            $end = $now;
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } elseif ($start == Carbon::parse($row->joining_date)) {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } else {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end);
                        }
                        if (Carbon::parse($row->joining_date)->gt($start)) {
                            $not_marked_attendance = '-';
                        } else {
                            if ($start->gt(Carbon::now())) {
                                $not_marked_attendance = '';
                            } else {

                                if ($now->eq($end)) {
                                    $public_holidays = holidaymodel::whereDate('holidaydate', '<=', $end)->whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereDate('startDate', '<=', $end)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                } else {
                                    $public_holidays = holidaymodel::whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                }
                                $attendance_marked_fulday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '>=', 8)->count();
                                $attendance_marked_halfday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '=', 4)->select('total_working_hours')->get();
                                $att_hl_day = 0;
                                if ($attendance_marked_halfday->isNotEmpty()) {
                                    foreach ($attendance_marked_halfday as $halfday) {
                                        $att_hl_day += 0.5;
                                    }
                                }

                                $leave_count = 0;
                                if ($leave_taken->isNotEmpty()) {
                                    foreach ($leave_taken as $lt) {
                                        $leave_count += $lt->noOfDayDeduct;
                                    }
                                }
                                $not_marked_attendance = $days - $public_holidays - $attendance_marked_fulday - $att_hl_day - $leave_count;
                            }
                        }

                        return $not_marked_attendance;
                    })
                    ->addColumn('nov', function ($row) use ($nov, $now) {
                        if (Carbon::parse($row->joining_date)->format('m') == Carbon::parse($nov)->format('m') && Carbon::parse($row->joining_date)->format('Y') == Carbon::parse($nov)->format('Y')) {
                            $start =  Carbon::parse($row->joining_date);
                        } else {
                            $start = Carbon::parse($nov->firstOfMonth());
                        }
                        $end = Carbon::parse($nov->endOfMonth());
                        if ($now->lt($end)) {
                            $end = $now;
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } elseif ($start == Carbon::parse($row->joining_date)) {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } else {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end);
                        }
                        if (Carbon::parse($row->joining_date)->gt($start)) {
                            $not_marked_attendance = '-';
                        } else {

                            if ($start->gt(Carbon::now())) {
                                $not_marked_attendance = '';
                            } else {

                                if ($now->eq($end)) {
                                    $public_holidays = holidaymodel::whereDate('holidaydate', '<=', $end)->whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereDate('startDate', '<=', $end)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                } else {
                                    $public_holidays = holidaymodel::whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                }
                                $attendance_marked_fulday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '>=', 8)->count();
                                $attendance_marked_halfday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '=', 4)->select('total_working_hours')->get();
                                $att_hl_day = 0;
                                if ($attendance_marked_halfday->isNotEmpty()) {
                                    foreach ($attendance_marked_halfday as $halfday) {
                                        $att_hl_day += 0.5;
                                    }
                                }

                                $leave_count = 0;
                                if ($leave_taken->isNotEmpty()) {
                                    foreach ($leave_taken as $lt) {
                                        $leave_count += $lt->noOfDayDeduct;
                                    }
                                }
                                $not_marked_attendance = $days - $public_holidays - $attendance_marked_fulday - $att_hl_day - $leave_count;
                            }
                        }

                        return $not_marked_attendance;
                    })
                    ->addColumn('dec', function ($row) use ($dec, $now) {
                        if (Carbon::parse($row->joining_date)->format('m') == Carbon::parse($dec)->format('m') && Carbon::parse($row->joining_date)->format('Y') == Carbon::parse($dec)->format('Y')) {
                            $start =  Carbon::parse($row->joining_date);
                        } else {
                            $start = Carbon::parse($dec->firstOfMonth());
                        }
                        $end = Carbon::parse($dec->endOfMonth());
                        if ($now->lt($end)) {
                            $end = $now;
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } elseif ($start == Carbon::parse($row->joining_date)) {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end) + 1;
                        } else {
                            $days = $start->diffInDaysFiltered(function (Carbon $date) {
                                return $date->isWeekday();
                            }, $end);
                        }
                        if (Carbon::parse($row->joining_date)->gt($start)) {
                            $not_marked_attendance = '-';
                        } else {

                            if ($start->gt(Carbon::now())) {
                                $not_marked_attendance = '';
                            } else {

                                if ($now->eq($end)) {
                                    $public_holidays = holidaymodel::whereDate('holidaydate', '<=', $end)->whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereDate('startDate', '<=', $end)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                } else {
                                    $public_holidays = holidaymodel::whereYear('holidaydate', $start)->whereMonth('holidaydate', '=', $start)->where('holidaystatus', '=', 1)->count();
                                    $leave_taken = LeaveApplication::where('user_id', $row->id)->whereYear('startDate', $start)->whereMonth('startDate', '=', $start)->where('leaveStatus', '=', 1)->select('noOfDayDeduct')->get();
                                }
                                $attendance_marked_fulday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '>=', 8)->count();
                                $attendance_marked_halfday = attendance::where('user_id', $row->id)->whereYear('attendance_date', $start)->whereMonth('attendance_date', '=', $start)->where('total_working_hours', '=', 4)->select('total_working_hours')->get();
                                $att_hl_day = 0;
                                if ($attendance_marked_halfday->isNotEmpty()) {
                                    foreach ($attendance_marked_halfday as $halfday) {
                                        $att_hl_day += 0.5;
                                    }
                                }

                                $leave_count = 0;
                                if ($leave_taken->isNotEmpty()) {
                                    foreach ($leave_taken as $lt) {
                                        $leave_count += $lt->noOfDayDeduct;
                                    }
                                }
                                $not_marked_attendance = $days - $public_holidays - $attendance_marked_fulday - $att_hl_day - $leave_count;
                            }
                        }


                        return $not_marked_attendance;
                    })


                    ->make(true);
            }
        }
        return view('report.attendance-summary.project-wise-attendance', compact('project'));
    }
}
