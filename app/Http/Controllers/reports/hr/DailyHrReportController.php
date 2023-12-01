<?php

namespace App\Http\Controllers\reports\hr;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobOffer;
use App\Models\JobPosition;
use App\Models\Projectmaster;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DailyHrReportController extends Controller
{
    public function dailyHR_report(Request $request)
    {
        $position = JobPosition::select('position_name', 'id')->get();
        $project = Projectmaster::select('id', 'project_name')->get();
        $hr = User::where('sub_role', 'hr')->select('name', 'id', 'employee_code')->get();

        if (request()->ajax()) {

            if ($request->from_date != '' && $request->to_date != '') {

                $from_date = Carbon::parse($request->from_date);
                $to_date = Carbon::parse($request->to_date);
                $received_date = Carbon::parse($request->received_date);

                if ($request->position != '' && $request->project != '' && $request->hr == '' && $request->received_date == '') { //client && position

                    $data = Job::where('position_id', '=', $request->position)->where('project_id', '=', $request->project)
                        ->whereDate('job_posted_date', '>=', $from_date)->whereDate('job_posted_date', '<=', $to_date)->get();
                } elseif ($request->position != '' && $request->project == '' && $request->hr == '' && $request->received_date == '') { //position only

                    $data = Job::where('position_id', '=', $request->position)
                        ->whereDate('job_posted_date', '>=', $from_date)->whereDate('job_posted_date', '<=', $to_date)->get();
                } elseif ($request->project != '' && $request->position == '' && $request->hr == '' && $request->received_date == '') { //project only

                    $data = Job::where('project_id', '=', $request->project)
                        ->whereDate('job_posted_date', '>=', $from_date)->whereDate('job_posted_date', '<=', $to_date)->get();
                } elseif ($request->hr != '' && $request->project == '' && $request->position == '' && $request->received_date == '') { //hr only

                    $data = Job::where('job_owner', '=', $request->hr)
                        ->whereDate('job_posted_date', '>=', $from_date)->whereDate('job_posted_date', '<=', $to_date)->get();
                } elseif ($request->received_date != '' && $request->hr == '' && $request->project == '' && $request->position == '') { // received date only

                    $data = Job::whereDate('received_date', '=', $received_date)
                        ->whereDate('job_posted_date', '>=', $from_date)->whereDate('job_posted_date', '<=', $to_date)->get();
                } elseif ($request->position == '' && $request->project != '' && $request->hr != '' && $request->received_date == '') { // client && hr

                    $data = Job::where('job_owner', '=', $request->hr)->where('project_id', '=', $request->project)
                        ->whereDate('job_posted_date', '>=', $from_date)->whereDate('job_posted_date', '<=', $to_date)->get();
                } elseif ($request->position == '' && $request->project != '' && $request->hr == '' && $request->received_date != '') { // client && received date

                    $data = Job::whereDate('received_date', '=', $received_date)->where('project_id', '=', $request->project)
                        ->whereDate('job_posted_date', '>=', $from_date)->whereDate('job_posted_date', '<=', $to_date)->get();
                } elseif ($request->position != '' && $request->project == '' && $request->hr == '' && $request->received_date != '') { // position && received date

                    $data = Job::whereDate('received_date', '=', $received_date)->where('position_id', '=', $request->position)
                        ->whereDate('job_posted_date', '>=', $from_date)->whereDate('job_posted_date', '<=', $to_date)->get();
                } elseif ($request->position != '' && $request->project == '' && $request->hr != '' && $request->received_date == '') { // position && hr

                    $data = Job::where('job_owner', '=', $request->hr)->where('position_id', '=', $request->position)
                        ->whereDate('job_posted_date', '>=', $from_date)->whereDate('job_posted_date', '<=', $to_date)->get();
                } elseif ($request->position == '' && $request->project == '' && $request->hr != '' && $request->received_date != '') { // hr && received date

                    $data = Job::whereDate('received_date', '=', $received_date)->where('job_owner', '=', $request->hr)
                        ->whereDate('job_posted_date', '>=', $from_date)->whereDate('job_posted_date', '<=', $to_date)->get();
                } elseif ($request->position != '' && $request->project != '' && $request->hr != '' && $request->received_date == '') { // client && position && hr

                    $data = Job::where('project_id', '=', $request->project)->where('position_id', '=', $request->position)->where('job_owner', '=', $request->hr)
                        ->whereDate('job_posted_date', '>=', $from_date)->whereDate('job_posted_date', '<=', $to_date)->get();
                } elseif ($request->position != '' && $request->project != '' && $request->hr == '' && $request->received_date != '') { // client && position && received date

                    $data = Job::where('project_id', '=', $request->project)->where('position_id', '=', $request->position)->whereDate('received_date', '=', $received_date)
                        ->whereDate('job_posted_date', '>=', $from_date)->whereDate('job_posted_date', '<=', $to_date)->get();
                } elseif ($request->position != '' && $request->project == '' && $request->hr != '' && $request->received_date != '') { // position && hr && received date

                    $data = Job::whereDate('received_date', '=', $received_date)->where('position_id', '=', $request->position)->where('job_owner', '=', $request->hr)
                        ->whereDate('job_posted_date', '>=', $from_date)->whereDate('job_posted_date', '<=', $to_date)->get();
                } elseif ($request->position == '' && $request->project != '' && $request->hr != '' && $request->received_date != '') { // client && received date && hr

                    $data = Job::where('project_id', '=', $request->project)->whereDate('received_date', '=', $received_date)->where('job_owner', '=', $request->hr)
                        ->whereDate('job_posted_date', '>=', $from_date)->whereDate('job_posted_date', '<=', $to_date)->get();
                } elseif ($request->position != '' && $request->project != '' && $request->hr != '' && $request->received_date != '') { // all != null

                    $data = Job::whereDate('received_date', '=', $received_date)->where('job_owner', '=', $request->hr)->where('project_id', '=', $request->project)
                        ->where('position_id', '=', $request->position)
                        ->whereDate('job_posted_date', '>=', $from_date)->whereDate('job_posted_date', '<=', $to_date)->get();
                } else { //job posted date only

                    $data = Job::whereDate('job_posted_date', '>=', $from_date)->whereDate('job_posted_date', '<=', $to_date)->get();;
                }
                return datatables($data)

                    ->addIndexColumn()

                    ->addColumn('project', function ($row) {
                        return $row->project->project_name;
                    })
                    ->addColumn('position', function ($row) {
                        return $row->position->position_name;
                    })
                    ->addColumn('job_owner', function ($row) {
                        return $row->user->name;
                    })
                    ->addColumn('status', function ($row) {
                        if ($row->job_status == 0) return 'Cancelled';
                        if ($row->job_status == 1) return 'Active';
                        if ($row->job_status == 2) return 'On Hold';
                        if ($row->job_status == 3) return 'Completed';
                    })

                    ->editColumn('joined', function ($row) {
                        $remaining_count = JobOffer::where('job_id', $row->id)->where('appointment_order_received', '=', 'Yes')->count();
                        return $remaining_count;
                    })

                    ->make(true);
            }
        }
        return view('report.hr.daily_hr_report', compact('position', 'project', 'hr'));
    }
}
