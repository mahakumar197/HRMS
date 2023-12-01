<?php

namespace App\Http\Controllers\consultancy;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\InterviewRound;
use App\Models\Job;
use App\Models\JobInterview;
use App\Models\JobScheduleModel;
use App\Models\SkillSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Models\HrQuestionnaire;

class Con_API extends Controller
{
    public function getJob_conref()
    {
        $consultancy_id = Auth::guard('consultancy')->id();

        $j = Job::with('consultancypivot')->whereHas('consultancypivot', function ($q) use ($consultancy_id) {
            $q->where('consultancy_id', '=', $consultancy_id)->where('ack', '=', '1');
        })->where('job_status', '=', '1')->get();


        return datatables($j)->addIndexColumn()

            ->addColumn('action', function ($row) {
                $action = '<a  href="cancreate/' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Add Candidate"><svg xmlns="http://www.w3.org/2000/svg"  width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2">
                      </path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></a>';
                return $action;
            })
            ->addColumn('view', function ($row) {
                $view = '<a href=" job-profile/' . $row->id . ' " data-toggle="tooltip" data-placement="top" title="View Job Details"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></a>';
                return $view;
            })
            ->addColumn('candidate_list', function ($row) {
                $view = '<a href="consultancy-job-candidate/' . $row->id . ' " data-toggle="tooltip" data-placement="top" title="Job Wise Candidate List">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                stroke-linejoin="round" class="feather feather-layers">
                <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline>
                <polyline points="2 12 12 17 22 12"></polyline></svg></a>';
                return $view;
            })


            ->addColumn('position', function ($row) {
                return $row->position->position_name;
            })
            ->addColumn('job_owner', function ($row) {
                return $row->user->name;
            })

            ->editColumn('job_status', function ($inquiry) {

                $position = $inquiry->position->position_name;

                if ($inquiry->job_status == 0) return 'Cancelled';
                if ($inquiry->job_status == 1) return 'Active';
                if ($inquiry->job_status == 2) return 'On Hold';
                if ($inquiry->job_status == 3) return 'Completed';
            })

            ->rawColumns(['action', 'job_status', 'view', 'candidate_list'])

            ->make(true);
    }



    //------------------------Candidate Index----------------------//
    public function getCandidate(Request $request)
    {
        if ($request->job_id != null) {
            $candidate = Candidate::where('consultancy_id', Auth::guard('consultancy')->id())->where('job_id', $request->job_id)->orderBy('created_at', 'DESC')->get();
        } else {
            $candidate = Candidate::where('consultancy_id', Auth::guard('consultancy')->id())->orderBy('created_at', 'DESC')->get();
        }


        return datatables($candidate)->addIndexColumn()

            ->addColumn('action', function ($row) {
                $can_interview = JobInterview::where('can_id', $row->id)->where('job_id', $row->job_id)->where('round_1_status', '!=', Null)->exists();
                $can_int_schedule = JobScheduleModel::where('can_id', '=', $row->id)->where('job_id', $row->job_id)->exists();

                if ($can_int_schedule == 'true' || $can_interview == 'true') {
                    $action = '<a  href="/consultancy/candidate/' . $row->id . ' " data-toggle="tooltip" data-placement="top" title="View Candidate Profile">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                    stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
                } else {
                    $action = '<a  href="/consultancy/candidate/' . $row->id . '/edit " data-toggle="tooltip" data-placement="top" title="Edit Candidate Profile">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
                    <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
                    <line x1="3" y1="22" x2="21" y2="22"></line></svg></a>';
                }



                return $action;
            })

            ->addColumn('int_status', function ($row) {

                $link = '<a href="#" onClick="testfunction(' . $row->id . ',' . $row->job_id . ')" data-toggle="tooltip" data-placement="top" title="Candidate Interview Status"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-paperclip">
                        <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path></svg></a>';

                return $link;
            })

            ->rawColumns(['action', 'int_status'])
            ->addColumn('job_code', function ($row) {
                return $row->job->job_code;
            })

            ->make(true);
    }



    public function job_data($id)
    {
        $job = Job::with(['position' => function ($p) {
            $p->select('id', 'position_name');
        }, 'job_type' => function ($j) {
            $j->select('id', 'job_type');
        }, 'user' => function ($u) {
            $u->select('id', 'name','last_name');
        }])->where('id', $id)
            ->select(
                'id',
                'position_id',
                'job_code',
                'candidate_type',
                'location',
                'job_description',
                'job_posted_date',
                'job_type_id',
                'headcount',
                'minimum_salary',
                'maximum_salary',
                'experience_required',
                'importance',
                'job_owner',
                'essential_skills',
                'desirable_skills'
            )->first();


        $job_essential_skill = $job->essential_skills;
        $job_desirable_skill = $job->desirable_skills;

        $essential_skills = SkillSet::whereIn('id', $job_essential_skill)->select('id', 'skillset')->get();
        //$desirable_skills = SkillSet::whereIn('id', $job_desirable_skill)->select('id', 'skillset')->get();
        
         if($job_desirable_skill != null){ 
       $desirable_skills = SkillSet::whereIn('id', $job_desirable_skill)->select('id', 'skillset')->get();
     }else{
         
         $desirable_skills = null;
     }


        return view('consultancy.job.job_profile', compact('job', 'essential_skills', 'desirable_skills'));
    }

    public function jobCandidateSummary($id)
    {
        return view('consultancy.candidate.index', compact('id'));
    }

    public function candidate_int_status(Request $request)
    {
        $int_status = JobInterview::where('can_id', $request->id)->where('job_id', $request->job_id)->first();

        $int_name = [];
        $int_result = [];
        if ($int_status != null) {
            for ($i = 1; $i <= 10; $i++) {
                $round = 'round_' . $i;
                $round_status = 'round_' . $i . '_status';
                if ($int_status->$round != null && $int_status->$round_status != null) {
                    $round_name = InterviewRound::where('id', $int_status->$round)->select('round_name')->first();
                    $int_name[] = $round_name->round_name;
                }
                if ($int_status->$round_status != null) {
                    $int_result[] = $int_status->$round_status;
                }
            }
        }
        return view('consultancy.candidate.can-int-status', compact('int_status', 'int_name', 'int_result'))->render();
    }
    
    public function show_details($id){

        $hr_feedback = HrQuestionnaire::where('id',$id)->first();

        $candidate_details = Candidate::with(['job' => function ($j) {
            $j->with(['position' => function ($p) {
                $p->select('id', 'position_name');
            }])->select('id', 'job_code', 'position_id');
        }, ])->where('id', $hr_feedback->can_id)->first();

        $job_interview = JobInterview::where('can_id',$hr_feedback->can_id)->where('job_id',$candidate_details->job->id)->first();

        return view('hr.interview_feedback.show.show_hr_feedback_con',compact('hr_feedback','job_interview','candidate_details'));
    }
}
