<?php

namespace App\Http\Controllers\hr\interview_feedback;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\HrQuestionnaire;
use App\Models\JobInterview;
use App\Models\JobScheduleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HRInterviewFeedback extends Controller
{
    public function hrInterview_feedback_form($id)
    {

        $candidate = JobScheduleModel::with(['jobdetails' => function ($j) {
            $j->with(['position' => function ($p) {
                $p->select('id', 'position_name');
            }])->select('id', 'job_code', 'position_id');
        }, 'candetails', 'jobinterview'])->where('id', '=', $id)->where('status', '=', 1)->first();


        if ($candidate && $candidate->interviewer_id == Auth::id()) {
            return view('hr.interview_feedback.hr_feedback', compact('candidate'));
        } else {
            return redirect()->back()->with('error', 'Interview Inactive');
        }
    }


    public function hr_submit_feedback($id)
    {

        $candidate = JobInterview::with(['jobdetails' => function ($j) {
            $j->with(['position' => function ($p) {
                $p->select('id', 'position_name');
            }])->select('id', 'job_code', 'position_id');
        }, 'candetails'])->where('id', '=', $id)->where('round_1_feedback', '=', null)->first();

        if ($candidate) {

            return view('hr.interview_feedback.hr_feedback', compact('candidate'));
        } else {

            return redirect()->back()->with('error', 'Feedback Already Submitted');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $validate = $request->validate([

            'hr_round_status' => 'required',
            'comments' => 'required',
        ]);

        $hr_questioner = new HrQuestionnaire();

        $hr_questioner->can_id = $request->can_id;
        $hr_questioner->job_id = $request->job_id;
        $hr_questioner->comments = $request->comments;       

        $hr_questioner->save();

        $comments = HrQuestionnaire::where('can_id', '=', $request->can_id)->where('job_id', '=', $request->job_id)->select('id')->first();

        $int_result = JobInterview::where('can_id', '=', $request->can_id)->where('job_id', '=', $request->job_id)->select('id')->first();
        $hr_result = JobInterview::find($int_result->id);

        $hr_result->round_1_feedback = $comments->id;
        $hr_result->round_1_status = $request->hr_round_status;
        $hr_result->update();

        $schedule_update = JobScheduleModel::find($request->sch_id);

        if ($schedule_update) {

            $schedule_update->status = 0;

            $schedule_update->update();
        }

        return redirect()->route('hr-screening', $request->job_id)->with('message', 'HR Round Feedback Saved Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hr_feedback = HrQuestionnaire::find($id);
        $interview_status = JobInterview::where('can_id', '=', $hr_feedback->can_id)->pluck('round_1_status')->first();

        $candidate = Candidate::where('id', '=', $hr_feedback->can_id)->with(['job' => function ($j) {
            $j->with(['position' => function ($p) {
                $p->select('position_name', 'id');
            }])->select('job_code', 'id', 'position_id');
        }])->select('name', 'job_id','id')->first();

        if (Auth::user()->role == 'super_admin' || Auth::user()->sub_role == 'hr') {
            return view('hr.interview_feedback.hr_feedback_edit', compact('hr_feedback', 'candidate', 'interview_status'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $validate = $request->validate([

            'hr_round_status' => 'required',
            'comments' => 'required',
        ]);
        $hr_questioner = HrQuestionnaire::find($id);
        $hr_questioner->can_id = $request->can_id;
        $hr_questioner->job_id = $request->job_id;
        $hr_questioner->comments = $request->comments;
               
        $hr_questioner->save();

        $int_result = JobInterview::where('can_id', '=', $request->can_id)->where('job_id', '=', $request->job_id)->select('id')->first();
        $hr_result = JobInterview::find($int_result->id);
        $hr_result->round_1_status = $request->hr_round_status;
        $hr_result->update();

       return redirect()->route('hr-screening', ['id' => $hr_questioner->job_id])->with('message', 'Candidate Feedback Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function show_details($id)
    {

        $hr_feedback = HrQuestionnaire::where('id', $id)->first();

        $candidate_details = Candidate::with(['job' => function ($j) {
            $j->with(['position' => function ($p) {
                $p->select('id', 'position_name');
            }])->select('id', 'job_code', 'position_id');
        },])->where('id', $hr_feedback->can_id)->first();

        $job_interview = JobInterview::where('can_id', $hr_feedback->can_id)->where('job_id', $candidate_details->job->id)->first();



        return view('hr.interview_feedback.show.show_hr_feedback', compact('hr_feedback', 'job_interview', 'candidate_details'));
    }
}
