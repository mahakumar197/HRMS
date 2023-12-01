<?php

namespace App\Console\Commands;

use App\Mail\attendanceNotMarkedPastDay;
use App\Models\holidaymodel;
use App\Models\TeamAllocations;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class attendnotmarkedemplastday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendancenotmarkedemp:twelvepm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        try {
            $today = Carbon::now();
            $yesterday = Carbon::yesterday();
            $ydate = $yesterday->format('d-m-Y');
            $hol_day = holidaymodel::whereYear('holidaydate', $today->year)->where('holidaystatus', '=', 1)->pluck('holidaydate')->toArray();
            $last_date = Carbon::yesterday()->subDay(1);
            for ($i = $last_date; $last_date->isWeekend() || in_array($last_date->format('Y-m-d'), $hol_day); $i->subDay(1)) {
                $lastWeekDay = $i;
            }
            $ldate = carbon::parse($lastWeekDay)->format('d-m-Y');

            $emp_attend_marked_yesterday = User::leftJoin('attendances', 'attendances.user_id', '=', 'users.id')
                ->whereDate('attendances.attendance_date', '=', $yesterday)->pluck('users.id');

            $emp_in_leave_yesterday = User::leftJoin('leave_applications', 'leave_applications.user_id', '=', 'users.id')
                ->whereDate('leave_applications.startDate', '<=', $yesterday)
                ->whereDate('leave_applications.endDate', '>=', $yesterday)->pluck('users.id');
            $ml_emp_yesterday = User::where('gender', '=', 'Female')
                ->where('ml_from_date', '<=', $yesterday)->where('ml_to_date', '>=', $yesterday)
                ->pluck('id')->toArray();

            $emp_yesterday = User::with(['team' => function ($t) use ($yesterday) {
                $t->with(['project' => function ($p) {
                    $p->select('id', 'project_name');
                }])->whereDate('start_date', '<=', $yesterday)->whereDate('end_date', '>=', $yesterday)->select('id', 'project_id', 'user_id');
            }])->select('id', 'email', 'name', 'last_name', 'employee_code')->where('employee_status', '=', '1')->orderBy(
                TeamAllocations::whereDate('start_date', '<=', $yesterday)->whereDate('end_date', '>=', $yesterday)->select('project_id')
                    ->whereColumn('team_allocations.user_id', 'users.id')
                    ->take(1),
                'asc'
            )->whereNotIn('id', $ml_emp_yesterday)->get();

            foreach ($emp_yesterday as $e) {
                $emp_not_in_leave = $emp_yesterday->whereNotIn('id', $emp_in_leave_yesterday);
                $emp_list_not_in_attendance = $emp_yesterday->whereNotIn('id', $emp_attend_marked_yesterday)->pluck('id');
                $attend_not_marked_yesterday = $emp_not_in_leave->whereIn('id', $emp_list_not_in_attendance);
            }

            //employee not marked in last week day//

            $emp_attend_marked_lastWeekDay = User::leftJoin('attendances', 'attendances.user_id', '=', 'users.id')
                ->whereDate('attendances.attendance_date', '=', $lastWeekDay)->pluck('users.id');

            $emp_in_leave_lastWeekDay = User::leftJoin('leave_applications', 'leave_applications.user_id', '=', 'users.id')
                ->whereDate('leave_applications.startDate', '<=', $lastWeekDay)
                ->whereDate('leave_applications.endDate', '>=', $lastWeekDay)->pluck('users.id');
            $ml_emp_lastWeekDay = User::where('gender', '=', 'Female')
                ->where('ml_from_date', '<=', $lastWeekDay)->where('ml_to_date', '>=', $lastWeekDay)
                ->pluck('id')->toArray();

            $emp_lastWeekDay = User::with(['team' => function ($t) use ($lastWeekDay) {
                $t->with(['project' => function ($p) {
                    $p->select('id', 'project_name');
                }])->whereDate('start_date', '<=', $lastWeekDay)->whereDate('end_date', '>=', $lastWeekDay)->select('id', 'project_id', 'user_id');
            }])->select('id', 'email', 'name', 'last_name', 'employee_code')->where('employee_status', '=', '1')->orderBy(
                TeamAllocations::whereDate('start_date', '<=', $lastWeekDay)->whereDate('end_date', '>=', $lastWeekDay)->select('project_id')
                    ->whereColumn('team_allocations.user_id', 'users.id')
                    ->take(1),
                'asc'
            )->whereNotIn('id', $ml_emp_lastWeekDay)->get();

            foreach ($emp_lastWeekDay as $e) {
                $emp_not_in_leave = $emp_lastWeekDay->whereNotIn('id', $emp_in_leave_lastWeekDay);
                $emp_list_not_in_attendance_lastWeekDay = $emp_lastWeekDay->whereNotIn('id', $emp_attend_marked_lastWeekDay)->pluck('id');
                $attend_not_marked_lastWeekday = $emp_not_in_leave->whereIn('id', $emp_list_not_in_attendance_lastWeekDay);
            }

            if ($today->isWeekday() == true && in_array($today->format('Y-m-d'), $hol_day) == false) {

                if ($yesterday->isWeekend() == true || in_array($yesterday->format('Y-m-d'), $hol_day) == true) {
                    foreach ($attend_not_marked_lastWeekday as $emp) {
                        //Log::info('Today is a not marked attendance ' .$emp->name);
                        Mail::to($emp->email)->send(new attendanceNotMarkedPastDay([$attend_not_marked_lastWeekday, $ldate]));
                    }
                } else {
                    foreach ($attend_not_marked_yesterday as $emp) {
                        //Log::info('Not marked attendance Yesterday' . $emp->name);
                        Mail::to($emp->email)->send(new attendanceNotMarkedPastDay([$attend_not_marked_yesterday, $ydate]));
                    }
                }
            } else {
                if ($today->isWeekend()) {
                    Log::info('Today is a Weekend ' . $today->englishDayOfWeek);
                } elseif (in_array($today->format('Y-m-d'), $hol_day) == true) {
                    Log::info('Today is a Sword Holiday.');
                }
            }
        } catch (Exception $e) {

            Log::info($e->getMessage());
        }
    }
}
