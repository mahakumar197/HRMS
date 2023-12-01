<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\User;
use App\Models\Agency;
use App\Models\JobInterview;
use App\Models\JobScheduleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\InterviewAPIService;

class Interview_API extends Controller
{

    private $interviewapiservice;
    public function __construct(InterviewAPIService $interviewapiservice)
    {
        $this->interviewapiservice = $interviewapiservice;
    }

    public function getHrSelected(Request $request)
    {
        $candidate = JobInterview::with([
            'candetails' => function ($c) {
                $c->select('id', 'name', 'resume_upload','phone_number','email','candidate_location','outsourced_via','referred_by','consultancy_id');
            }, 'jobdetails'=>function($j){
                $j->select('id','job_code','position_id')->with(['position'=>function($p){
                    $p->select('id','position_name');
                }]);
            }
        ])
            ->where('job_id', $request->job_id)
            ->where('round_1_status', '=', 2)
            ->get();            
        return datatables($candidate)->addIndexColumn()

            ->addColumn('job_code', function ($row) {
                return $row->jobdetails->job_code;
            })
            ->addColumn('candidate_created_date', function ($row) {
                return $row->candetails->candidate_created_date;
            })
            ->addColumn('name', function ($row) {
                return $row->candetails->name;
            })
            ->addColumn('phone_number', function ($row) {
                return $row->candetails->phone_number;
            })
            ->addColumn('email', function ($row) {
                return $row->candetails->email;
            })
            ->addColumn('candidate_location', function ($row) {
                return $row->candetails->candidate_location;
            })
            ->addColumn('resume', function ($row) {
                return $row->candetails->resume_upload;
            })
            ->addColumn('referred_by', function ($row) {
                
                if($row->candetails->outsourced_via != null){
                    $referred_by = $row->candetails->outsourced_via;
                }
                elseif($row->candetails->referred_by != null){
                    $referred_by = User::where('employee_code','=',$row->candetails->referred_by)->select('name')->first();
                    $referred_by = $referred_by->name;

                }
                elseif($row->candetails->consultancy_id != null){
                    $referred_by = Agency::where('id',$row->candetails->consultancy_id)->select('consultancy_name')->first();
                    $referred_by = $referred_by->consultancy_name;
                }                                
                return $referred_by;
            })
            ->addColumn('action', function ($row) {
                $action = '<a href="/hr-interview-feedback/' . $row->round_1_feedback . '/edit" class="del_ btn btn-xs btn-warning btn-edit" id="923"><i class="fa fa-edit"></i> Feedback</a>';
                return $action;
            })
            ->make(true);
    }
    public function getHrRejected(Request $request)
    {        
        $candidate = JobInterview::with([
            'candetails' => function ($c) {
                $c->select('id', 'name', 'resume_upload','phone_number','email','candidate_location','outsourced_via','referred_by','consultancy_id');
            }, 'jobdetails'=>function($j){
                $j->select('id','job_code','position_id')->with(['position'=>function($p){
                    $p->select('id','position_name');
                }]);
            }
        ])
            ->where('job_id', $request->job_id)
            ->where('round_1_status', '=', 3)
            ->get();
            
        return datatables($candidate)->addIndexColumn()

            ->addColumn('job_code', function ($row) {
                return $row->jobdetails->job_code;
            })
            ->addColumn('candidate_created_date', function ($row) {
                return $row->candetails->candidate_created_date;
            })
            ->addColumn('name', function ($row) {
                return $row->candetails->name;
            })
            ->addColumn('phone_number', function ($row) {
                return $row->candetails->phone_number;
            })
            ->addColumn('email', function ($row) {
                return $row->candetails->email;
            })
            ->addColumn('candidate_location', function ($row) {
                return $row->candetails->candidate_location;
            })
            ->addColumn('resume', function ($row) {
                return $row->candetails->resume_upload;
            })
            ->addColumn('referred_by', function ($row) {
                
                if($row->candetails->outsourced_via != null){
                    $referred_by = $row->candetails->outsourced_via;
                }
                elseif($row->candetails->referred_by != null){
                    $referred_by = User::where('employee_code','=',$row->candetails->referred_by)->select('name')->first();
                    $referred_by = $referred_by->name;

                }
                elseif($row->candetails->consultancy_id != null){
                    $referred_by = Agency::where('id',$row->candetails->consultancy_id)->select('consultancy_name')->first();
                    $referred_by = $referred_by->consultancy_name;
                }                                
                return $referred_by;
            })
            ->addColumn('action', function ($row) {
                $action = '<a href="/hr-interview-feedback/' . $row->round_1_feedback . '/edit" class="del_ btn btn-xs btn-warning btn-edit" id="923"><i class="fa fa-edit"></i> Feedback</a>';
                return $action;
            })
            

            ->make(true);
    }

    public function getHrNotInterviewed(Request $request)
    {
        $candidate = JobInterview::with([
            'candetails' => function ($c) {
                $c->select('id', 'name', 'resume_upload','phone_number','email','candidate_location','outsourced_via','referred_by','consultancy_id');
            }, 'jobdetails'=>function($j){
                $j->select('id','job_code','position_id')->with(['position'=>function($p){
                    $p->select('id','position_name');
                }]);
            }
        ])
            ->where('job_id', $request->job_id)
            ->where('round_1_status', '=', null)
            ->get();

        return datatables($candidate)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $action = '<a href="/hr-submit-feedback/' . $row->id . '/" class="del_ btn btn-xs btn-success btn-edit" id="923">Feedback</a>';
                return $action;
            })
            ->addColumn('job_code', function ($row) {
                return $row->jobdetails->job_code;
            })
            ->addColumn('candidate_created_date', function ($row) {
                return $row->candetails->candidate_created_date;
            })
            ->addColumn('name', function ($row) {
                return $row->candetails->name;
            })
            ->addColumn('phone_number', function ($row) {
                return $row->candetails->phone_number;
            })
            ->addColumn('email', function ($row) {
                return $row->candetails->email;
            })
            ->addColumn('candidate_location', function ($row) {
                return $row->candetails->candidate_location;
            })
            ->addColumn('resume', function ($row) {
                return $row->candetails->resume_upload;
            })
            ->addColumn('referred_by', function ($row) {
                
                if($row->candetails->outsourced_via != null){
                    $referred_by = $row->candetails->outsourced_via;
                }
                elseif($row->candetails->referred_by != null){
                    $referred_by = User::where('employee_code','=',$row->candetails->referred_by)->select('name')->first();
                    $referred_by = $referred_by->name;

                }
                elseif($row->candetails->consultancy_id != null){
                    $referred_by = Agency::where('id',$row->candetails->consultancy_id)->select('consultancy_name')->first();
                    $referred_by = $referred_by->consultancy_name;
                }                                
                return $referred_by;
            })

            ->make(true);
    }

    /*
    public function can_interview(Request $request){
       // dd($request->job_id);
        $round_status = "round_".$request->round_id."_status";       
        $test = $this->interviewapiservice->interview_details($request->job_id , $request->round_id, $round_status);
        return $test;
    }*/

    public function more_candidate(Request $request)
    {
        $job_id = $request->job_id;
        $candidate = $this->interviewapiservice->more_candidate_details($job_id);
        // return view('hr.interview..page.page-data',compact('candidate'))->render();
        return $candidate;
    }


    public function get_can_details(Request $request)
    {
        $can_details = JobInterview::with(['candetails', 'jobdetails', 'roundname1', 'roundname2', 'roundname3', 'roundname4', 'roundname5', 'roundname6', 'roundname7'])
            ->where('id', '=', $request->id)
            ->first();

        $schedule =  JobScheduleModel::with(['interviewer'=>function($i){
            $i->select('id','name','image_path','designation_id')->with(['designation'=>function($d){
                $d->select('id','designation');
            }]);
        }])->where('can_id', '=', $can_details->can_id)->where('job_id', '=', $request->job)->get();
       
        return view('hr.interview.page.can-details', compact('can_details', 'schedule'))->render();
    }


    public function get_feedcan_details(Request $request)
    {
        

        $round = intval($request->c);

        $can_details = JobInterview::with(['candetails', 'jobdetails', 'roundname1', 'roundname2', 'roundname3', 'roundname4', 'roundname5', 'roundname6', 'roundname7'])
            ->where('id', '=', $request->a)
            ->first();


        $schedule =  JobScheduleModel::where('can_id', '=', $can_details->can_id)->where('job_id', '=', $request->b)->get();


        return view('hr.interview_feedback.page.can-feedback', compact('can_details', 'schedule', 'round'))->render();
    }

    public function get_feedback_details(Request $request)
    {


        $feedback = $this->interviewapiservice->feedback_details($request->job, $request->round, $request->can_id, $request->round_id, $request->feedback_type,);


        return $feedback;
    }
}
