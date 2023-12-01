<?php

namespace App\Http\Controllers\reports\hr;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use App\Models\Candidate;
use App\Models\JobOffer;
use App\Models\JobPosition;
use App\Models\Projectmaster;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OfferedJoinersReport extends Controller
{
    public function offeredJoinersReport(Request $request)
    {
        $position = JobPosition::select('position_name', 'id')->get();
        $project = Projectmaster::select('id', 'project_name')->get();



        if (request()->ajax()) {

            if ($request->from_date != '' && $request->to_date != '') {

                $from_date = Carbon::parse($request->from_date);
                $to_date = Carbon::parse($request->to_date);
                $received_date = Carbon::parse($request->received_date);
                $offer_process = JobOffer::where('offer_letter', '=', 'Yes')->select('can_id')->get();

                if ($request->position != '' && $request->project != '' && $request->offer != '') { //client && position && offer

                    $data = JobOffer::whereDate('ol_date', '>=', $from_date)->whereHas('jobdetails', function ($j) use ($request) {
                        $j->where('position_id', '=', $request->position)->where('project_id', '=', $request->project);
                    })->whereDate('ol_date', '<=', $to_date)->where('offer_ack', '=', $request->offer)->get();
                } elseif ($request->position != '' && $request->project == '' && $request->offer == '') { //only position
                    $data = JobOffer::whereDate('ol_date', '>=', $from_date)->whereHas('jobdetails', function ($j) use ($request) {
                        $j->where('position_id', '=', $request->position);
                    })->whereDate('ol_date', '<=', $to_date)->get();
                } elseif ($request->position == '' && $request->project != '' && $request->offer == '') { //only project
                    $data = JobOffer::whereDate('ol_date', '>=', $from_date)->whereHas('jobdetails', function ($j) use ($request) {
                        $j->where('project_id', '=', $request->project);
                    })->whereDate('ol_date', '<=', $to_date)->get();
                } elseif ($request->position == '' && $request->project == '' && $request->offer != '') { //only offer
                    $data = JobOffer::whereDate('ol_date', '>=', $from_date)->whereDate('ol_date', '<=', $to_date)->where('offer_ack', '=', $request->offer)->get();
                } elseif ($request->position != '' && $request->project != '' && $request->offer == '') { //client && position
                    $data = JobOffer::whereDate('ol_date', '>=', $from_date)->whereHas('jobdetails', function ($j) use ($request) {
                        $j->where('position_id', '=', $request->position)->where('project_id', '=', $request->project);
                    })->whereDate('ol_date', '<=', $to_date)->get();
                } elseif ($request->position == '' && $request->project != '' && $request->offer != '') { //client && offer
                    $data = JobOffer::whereDate('ol_date', '>=', $from_date)->whereHas('jobdetails', function ($j) use ($request) {
                        $j->where('project_id', '=', $request->project);
                    })->whereDate('ol_date', '<=', $to_date)->where('offer_ack', '=', $request->offer)->get();
                } elseif ($request->position != '' && $request->project == '' && $request->offer != '') { //position && offer
                    $data = JobOffer::whereDate('ol_date', '>=', $from_date)->whereHas('jobdetails', function ($j) use ($request) {
                        $j->where('position_id', '=', $request->position);
                    })->whereDate('ol_date', '<=', $to_date)->where('offer_ack', '=', $request->offer)->get();                    
                } else { //offer date only

                    $data = JobOffer::whereDate('ol_date', '>=', $from_date)->whereDate('ol_date', '<=', $to_date)->get();
                }
                return datatables($data)

                    ->addIndexColumn()

                    ->addColumn('name', function ($row) {
                        return $row->candetails->name;
                    })
                    ->addColumn('email', function ($row) {
                        return $row->candetails->email;
                    })
                    ->addColumn('phone_number', function ($row) {
                        return $row->candetails->phone_number;
                    })
                    ->addColumn('job_code', function ($row) {
                        return $row->jobdetails->job_code;
                    })
                    ->addColumn('project', function ($row) {
                        return $row->jobdetails->project->project_name;
                    })
                    ->addColumn('position', function ($row) {
                        return $row->jobdetails->position->position_name;
                    })
                    ->addColumn('job_type', function ($row) {
                        return $row->jobdetails->candidate_type;
                    })
                    ->addColumn('status', function ($row) {
                        $row->offer_ack == 'Yes' ? $status = 'Joined' : $status = 'No Show';
                        return $status;
                    })

                    ->addColumn('source', function ($row) {
                        if ($row->candetails->outsourced_via != null) {
                            $referred_by = $row->candetails->outsourced_via;
                        } elseif ($row->candetails->referred_by != null) {
                            $referred_by = User::where('employee_code', '=', $row->candetails->referred_by)->select('name', 'employee_code')->first();
                            $referred_by = "{$referred_by->name} - {$referred_by->employee_code}";
                        } elseif ($row->candetails->consultancy_id != null) {
                            $referred_by = Agency::where('id', $row->candetails->consultancy_id)->select('consultancy_name')->first();
                            $referred_by = $referred_by->consultancy_name;
                        }
                        return $referred_by;
                    })
                    ->addColumn('edjo', function ($row) {
                        return $row->joining_date != null ? $row->joining_date : null;
                    })
                    ->addColumn('accepted_declined', function ($row) {

                        return $row->offer_ack != null ? $row->offer_ack : '';
                    })

                    ->make(true);
            }
        }
        return view('report.hr.offered_joiners_report', compact('position', 'project'));
    }
}
