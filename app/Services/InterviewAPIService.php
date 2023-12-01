<?php

namespace App\Services;


use App\Models\JobInterview;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;
use App\Models\HrQuestionnaire;
use App\Models\TechFeedbackModel;
use App\Models\SkillFeedbackModel;
use App\Models\CommonInterviewFeedback;
use App\Models\Agency;
use App\Models\User;




/**
 * Class AttendanceService
 * @package App\Services
 */
class InterviewAPIService
{
    /**
     * @return mixed
     */
    /* public function interview_details($job_id=null , $round_id=null, $round_status){

    

         $candidate =  JobInterview::with('candetails')->where('job_id',$job_id)->where($round_status,'=',0)->select($round_status,'can_id')->get();
            
             
         
        return datatables($candidate)->addIndexColumn()
            ->addColumn('action', function ($row) {

                $action = '<a href="/hr-interview-feedback/'. $row->can_id .'" class="del_ btn btn-xs btn-success btn-edit" id="923">Feedback</a>';

                return $action;
            })
            ->addColumn('job_code', function ($row) {
                return $row->job_code;
            })
            ->addColumn('candidate_created_date', function ($row) {
                return $row->candidate_created_date;
            })
            ->addColumn('name', function ($row) {
                return $row->name;
            })
            ->addColumn('phone_number', function ($row) {
                return $row->phone_number;
            })
            ->addColumn('email', function ($row) {
                return $row->email;
            })
            ->addColumn('candidate_location', function ($row) {
                return $row->candidate_location;
            })
            ->addColumn('resume', function ($row) {
                return $row->resume_upload;
            })

            ->make(true);
   }

*/

    public function more_candidate_details($job_id)
    {

        $candidate = JobInterview::with([
            'candetails' => function ($c) {
                $c->select('id', 'name', 'resume_upload', 'phone_number', 'email', 'candidate_location', 'outsourced_via', 'referred_by', 'consultancy_id');
            }, 'jobdetails' => function ($j) {
                $j->select('id', 'job_code', 'position_id')->with(['position' => function ($p) {
                    $p->select('id', 'position_name');
                }]);
            }, 'roundname1', 'roundname2', 'roundname3', 'roundname4', 'roundname5', 'roundname6', 'roundname7'
        ])
            ->where('job_id', '=', $job_id)->get();


        return datatables($candidate)->addIndexColumn()

            ->addColumn('name', function ($row) {
                $name = '<a href="/candidate/' . $row->id . '" target="_blank">' . $row->candetails->name . '</a>';
                return $name;
            })
            ->addColumn('job', function ($row) {
                return $row->jobdetails->job_code;
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
                $resume = '<a href="/resume/' . $row->candetails->resume_upload . '" class="" >View/Download</a>';
                return   $resume;
            })

            ->addColumn('status', function ($row) {                

                for ($i = 1; $i <= 10; $i++) {
                    $round = 'round_' . $i;
                    $round_status = 'round_' . $i . '_status';
                    //$status = '';                    
                    if ($row->$round != null && isset($row->$round_status)) {
                        switch ($row->$round_status) {                           
                            case (0):
                                $roundname = 'roundname' . $i;
                                $round_name = $row->$roundname->round_name;
                                $status = $round_name . ' - Scheduled';
                                break;
                            case (1):
                                $roundname = 'roundname' . $i;
                                $round_name = $row->$roundname->round_name;
                                $status = $round_name . ' - OnHold';
                                break;
                            case (2):
                                $roundname = 'roundname' . $i;
                                $round_name = $row->$roundname->round_name;
                                $status = $round_name . ' - Selected';
                                break;
                            case (3):
                                $roundname = 'roundname' . $i;
                                $round_name = $row->$roundname->round_name;
                                $status = $round_name . ' - Rejected';
                                break;
                        }
                    }                   
                    
                }
                if($row->round_1_status == Null){
                   $round_name =  $row->roundname1->round_name;
                    $status=$round_name.' - To Be Scheduled';
                }



                return $status;
            })

            ->addColumn('action', function ($row) {

                $action = '<a href="#" class="del_ btn btn-sm btn-success btn-edit"  onclick="getcandetails(' . $row->id . ',' . $row->job_id . ')">Interview</a>';
                return   $action;
            })
            ->rawColumns(['action', 'resume', 'name'])

            ->addColumn('referred_by', function ($row) {

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

            ->make(true);
    }

    public function feedback_details($round, $job, $can_id, $round_id, $feedback_type)
    {



        switch ($feedback_type) {

            case "0":

                $feedback_get =  CommonInterviewFeedback::with('candetails', 'jobdetails')->where('id', '=', $round_id)->first();



                $feedback = view('hr.interview.page.common-feedback', compact('feedback_get'))->render();



                return $feedback;

                break;

            case "1":

                $feedback_get =  HrQuestionnaire::with('candetails', 'jobdetails')->where('id', '=', $round_id)->first();

                $feedback = view('hr.interview.page.hr-feedback', compact('feedback_get'))->render();

                return $feedback;

                break;

            case "2":

                $feedback_get =  TechFeedbackModel::with('candetails', 'jobdetails')->where('id', '=', $round_id)->first();



                if ($feedback_get) {

                    $skill = SkillFeedbackModel::with('skillname')->whereIn('id', $feedback_get->skill_detail)->get();
                } else {

                    $skill = null;
                }



                $feedback = view('hr.interview.page.tech-feedback', compact('feedback_get', 'skill'))->render();

                return $feedback;

                break;

            default:

                $feedback = '';

                return $feedback;

                break;
        }
    }
}
