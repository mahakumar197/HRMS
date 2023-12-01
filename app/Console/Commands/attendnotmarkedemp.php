<?php

namespace App\Console\Commands;


use App\Mail\notattendmail;
use App\Models\holidaymodel;
use App\Models\TeamAllocations;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class attendnotmarkedemp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendancenotmarkedemp:threepm';

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
            $date = $today->format('d-m-Y');
            $hol_day = holidaymodel::whereYear('holidaydate', $today->year)->where('holidaystatus','=',1)->pluck('holidaydate')->toArray();

            $emp_attend_marked = User::leftJoin('attendances', 'attendances.user_id', '=', 'users.id')
                ->whereDate('attendances.attendance_date', '=', $today)->pluck('users.id');

            $emp_in_leave = User::leftJoin('leave_applications', 'leave_applications.user_id', '=', 'users.id')
                ->whereDate('leave_applications.startDate', '<=', $today)
                ->whereDate('leave_applications.endDate', '>=', $today)->pluck('users.id');
            $ml_emp = User::where('gender', '=', 'Female')
                ->where('ml_from_date', '<=', $today)->where('ml_to_date', '>=', $today)
                ->pluck('id')->toArray();

            $emp = User::with(['team' => function ($t) use ($today) {
                $t->with(['project' => function ($p) {
                    $p->select('id', 'project_name');
                }])->whereDate('start_date', '<=', $today)->whereDate('end_date', '>=', $today)->select('id', 'project_id', 'user_id');
            }])->select('id', 'email', 'name','last_name', 'employee_code')->where('employee_status', '=', '1')->orderBy(
                TeamAllocations::whereDate('start_date', '<=', $today)->whereDate('end_date', '>=', $today)->select('project_id')
                    ->whereColumn('team_allocations.user_id', 'users.id')
                    ->take(1),
                'asc'
            )->whereNotIn('id', $ml_emp)->get();

            foreach ($emp as $e) {
                $emp_not_in_leave = $emp->whereNotIn('id', $emp_in_leave);
                $emp_list_not_in_attendance = $emp->whereNotIn('id', $emp_attend_marked)->pluck('id');
                $attend_not_marked = $emp_not_in_leave->whereIn('id', $emp_list_not_in_attendance);
            }            

            if ($today->isWeekday() == true && in_array($today->format('Y-m-d'), $hol_day) == false) {              

                foreach ($attend_not_marked as $emp) {
                    Mail::to($emp->email)->send(new notattendmail([$attend_not_marked, $date]));
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
