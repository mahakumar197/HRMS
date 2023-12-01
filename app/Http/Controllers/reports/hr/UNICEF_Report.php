<?php

namespace App\Http\Controllers\reports\hr;

use App\Http\Controllers\Controller;
use App\Models\HrQuestionnaire;
use App\Models\Job;
use App\Models\JobInterview;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UNICEF_Report extends Controller
{
    public function unicefReport(Request $request)
    {

        if (request()->ajax()) {

            if ($request->from_date != '' && $request->to_date != '') {

                $from_date = Carbon::parse($request->from_date);
                $to_date = Carbon::parse($request->to_date);


                $data = Job::whereDate('received_date', '>=', $from_date)->whereDate('received_date', '<=', $to_date)->get();

                return datatables($data)

                    ->addIndexColumn()

                    ->addColumn('position', function ($row) {
                        return $row->position->position_name;
                    })
                    ->addColumn('cv_shared', function ($row) {


                        $hr_round_status = JobInterview::where('job_id', '=', $row->id)->where('round_1_status', '=', 2)->select('can_id')->get();

                        if ($hr_round_status->isNotEmpty()) {

                            $hr_feedback = HrQuestionnaire::whereIn('can_id', $hr_round_status)
                                ->whereDate('created_at', '<=', Carbon::parse($row->submit_date))->count();
                        } else {
                            $hr_feedback = '';
                        }
                        return $hr_feedback;
                    })

                    ->make(true);
            }
        }
        return view('report.hr.unicef_report');
    }
}
