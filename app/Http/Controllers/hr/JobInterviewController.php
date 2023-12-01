<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\InterviewTemplateModel;
use App\Models\Job;
use App\Models\Candidate;
use App\Models\InterviewRound;
use Illuminate\Http\Request;
use App\Models\JobInterview;
use App\Models\HrQuestionnaire;
use App\Models\JobOffer;

class JobInterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function job_candidate($job_id)
    {

        /* pagination code  
        
        $candidate = JobInterview::with(['candetails','jobdetails','roundname1','roundname2','roundname3','roundname4','roundname5','roundname6','roundname7'])->where('job_id','=','22')->paginate(5);
         
        */

        $job = Job::where('id', $job_id)->select('job_code', 'project_id', 'position_id', 'location', 'job_status', 'job_owner', 'headcount')->first();
        $candidate = Candidate::where('job_id', $job_id)->count();
        $recruited = JobOffer::where('job_id', $job_id)->where('appointment_order_received', '=', 'Yes')->count();
        $recruited_list = JobOffer::where('job_id', $job_id)->where('appointment_order_received', '=', 'Yes')->select('can_id')->get();
        $recruited_can = JobOffer::where('job_id', $job_id)->where('appointment_order_received', '=', 'Yes')->pluck('can_id')->toArray();

        $remaining_count = $job->headcount - $recruited;

        $job_result = JobInterview::where('job_id', $job_id)->get();
        $selected_count = 0;
        $rejected_count = 0;
        $rejected_can = [];
        $selected_can = [];

        foreach ($job_result as $jr) {
            $result = [];
            $result_status = [];
            $reject_status = [];

            for ($i = 1; $i <= 10; $i++) {
                $round = 'round_' . $i;
                $round_status = 'round_' . $i . '_status';
                if ($jr->$round != null) {
                    $result[] = $jr->$round;
                }
                if ($jr->$round_status != null && $jr->$round_status == 2) {
                    $result_status[] = $jr->$round_status;
                }
                if ($jr->$round_status != null && $jr->$round_status == 3) {
                    $reject_status[] = $jr->$round_status;
                    $rejected_can[] = $jr->can_id;
                }
            }
            if (count($result) == count($result_status)) {
                ++$selected_count;
                $selected_can[] = $jr->can_id;
            }
            if ($reject_status != null) {
                ++$rejected_count;
            }
        }
        $rejected_candidate = Candidate::whereIn('id', $rejected_can)->select('name')->get();
        $selected_candidate = Candidate::whereIn('id', $selected_can)->whereNotIn('id',$recruited_can)->select('name')->get();      

        $selected = $selected_count - $recruited;
        $pipeline = $candidate - $rejected_count - $recruited - $selected;
        $p = array_merge($rejected_can, $selected_can, $recruited_can);

        $pipeline_can = Candidate::where('job_id', $job_id)->whereNotIn('id', $p)->select('name')->get();


        return view('hr.interview.candidate_interview', compact('job_id', 'pipeline_can', 'recruited_list', 'rejected_candidate', 'selected_candidate', 'job', 'remaining_count', 'selected', 'selected_count', 'recruited', 'rejected_count', 'pipeline'));
    }



    public function hr_screening($job_id)
    {
        $job = Job::where('id', $job_id)->select('job_code', 'project_id', 'position_id', 'location', 'job_status', 'job_owner', 'headcount')->first();
        $recruited = JobOffer::where('job_id', $job_id)->where('appointment_order_received', '=', 'Yes')->count();
        $remaining_count = $job->headcount - $recruited;
        $candidate = Candidate::where('job_id', $job_id)->count();
        $hr_selected = JobInterview::where('job_id', $job_id)->where('round_1_status', '=', '2')->pluck('can_id')->toArray();
        $hr_rejected = JobInterview::where('job_id', $job_id)->where('round_1_status', '=', '3')->pluck('can_id')->toArray();
        $p = array_merge($hr_rejected,$hr_selected);
        $pipeline = $candidate - count($hr_selected) - count($hr_rejected);
        $hr_selected = Candidate::where('job_id', $job_id)->whereIn('id',$hr_selected)->pluck('name')->toArray();
        $hr_rejected = Candidate::where('job_id', $job_id)->whereIn('id',$hr_rejected)->pluck('name')->toArray();
        $hr_pipeline = Candidate::where('job_id', $job_id)->whereNotIn('id',$p)->pluck('name')->toArray();


        return view('hr.interview.candidate_interview_screening', compact('hr_pipeline','job', 'job_id', 'remaining_count', 'hr_selected', 'hr_rejected', 'pipeline'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $candit = Candidate::where('job_id', '=', $id)->get();

        if ($candit->isEmpty()) {
            $job = Job::where('id', $id)->first();
            $imp = implode(',', $job->rounds);

            $job_in = InterviewRound::whereIn('id', $job->rounds)->orderByRaw("FIELD(id, {$imp})")->get();

            $job_notin = InterviewRound::WhereNotIn('id', $job->rounds)->get();
            return view('hr.job_interview.edit', compact('job_notin', 'job_in', 'job'));
        } else {

            return redirect()->route('job.index')->with('error', 'Candidate Already Created. Cant Edit Job Rounds');
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

        $validation = $request->validate([

            'job_round' => 'required',
        ]);

        $job_round = array_map('intval', request('job_round'));

        $job = Job::find($id);

        $job->rounds = $job_round;

        $job->update();

        return redirect()->route('job.index')->with('message', 'Interview Rounds for ' . $job->job_code . ' Created Successfully.');
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


    public function jobround($id)
    {

        $candit = Candidate::where('job_id', '=', $id)->get();

        if ($candit->isEmpty()) {

            $job = Job::find($id);
            // $job_int = InterviewTemplateModel::where('position_id',$job->position_id)->first();
            $job_int = InterviewRound::get();

            return view('hr.job_interview.create', compact('job_int', 'job'));
        } else {

            return redirect()->route('job.index')->with('error', 'Candidate Already Created.');
        }
    }


    public function jobround_save(Request $request)
    {


        $validation = $request->validate([

            'job_round' => 'required',
        ]);

        $job_round = array_map('intval', request('job_round'));
        $job = Job::find($request->job_id);
        $job->rounds = $job_round;
        $job->update();

        return redirect()->route('job.index')->with('message', 'Interview Rounds for ' . $job->job_code . ' Created Successfully.');
    }



    public function canIntRound($id)
    {

        $candit = Candidate::where('id', '=', $id)->select('id', 'job_id')->first();

        $can_int_stored = JobInterview::where('can_id', $id)->where('job_id', $candit->job_id)->first();

        $int_array = [];
        for ($i = 1; $i <= 10; $i++) {
            $round = 'round_' . $i;
            if ($can_int_stored->$round != null) {
                $int_array[] = $can_int_stored->$round;
            }
        }
        $imp = implode(',', $int_array);

        $job = Job::where('id', $candit->job_id)->first();

        $round_selected = [];

        for ($i = 1; $i <= 10; $i++) {
            $round = 'round_' . $i;
            $round_status = 'round_' . $i . '_status';
            if ($can_int_stored->$round_status != null && $can_int_stored->$round != null) {
                $round_selected[] = $can_int_stored->$round;
            }
        }
        $int_comp = implode(',', $round_selected);
        $round_completed = InterviewRound::whereIn('id', $round_selected)->orderByRaw("FIELD(id, {$imp})")->get();

        $job_in = InterviewRound::whereIn('id', $int_array)->whereNotIn('id', $round_selected)->orderByRaw("FIELD(id, {$imp})")->get();

        $job_notin = InterviewRound::WhereNotIn('id', $int_array)->get();
        return view('hr.job_interview.candidate_int_edit', compact('job_notin', 'job_in', 'job', 'round_completed', 'candit', 'id'));
    }

    public function canIntRound_save(Request $request)
    {

        $int_round_can = JobInterview::where('job_id', $request->job_id)->where('can_id', $request->can_id)->select('id')->first();
        $int_round = JobInterview::find($int_round_can->id);

        $i = 1;
        foreach ($request->job_round as $jr) {

            $round = 'round_' . $i;

            $int_round->$round = $jr;


            $i++;
        }
        $j = 10 - $i;

        for ($i; $i <= 10; $i++) {

            $round = 'round_' . $i;

            $int_round->$round = Null;
        }

        $int_round->update();

        return redirect()->route('candidate.index')->with('message', 'Updated Successfully.');
    }
}
