<?php

namespace App\Http\Controllers\consultancy;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\InterviewRound;
use App\Models\Job;
use App\Models\JobInterview;
use App\Models\JobScheduleModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Mail\new_candidate;

use Illuminate\Support\Facades\Mail;

class ConCandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = '';
        return view('consultancy.candidate.index', compact('id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $job = Job::get();
        return view('consultancy.candidate.create', compact('job'));
    }

    public function cancreate($id)
    {

        $job = Job::with(['position', 'project', 'user'])->where('id', $id)->first();
        $hr = User::where('sub_role', '=', 'hr')->select('id', 'name')->get();

        $consultancy_id = Auth::guard('consultancy')->id();

        if (Auth::user()->sub_role != 'hr' && Auth::user()->role != 'super_admin') {
            $check_ack = Job::with('consultancypivot')->whereHas('consultancypivot', function ($q) use ($consultancy_id, $id) {
                $q->where('consultancy_id', '=', $consultancy_id)->where('jobs_id', '=', $id)->where('ack', '=', '1');
            })->where('job_status', '=', '1')->get();

            if ($check_ack->isEmpty()) {
                return redirect()->route('consultancy.referral')->with('message2', 'You are not authorised to create candidate.');
            } else {
                return view('consultancy.candidate.create', compact('job', 'hr'));
            }
        } else {
        }

        return view('consultancy.candidate.create', compact('job', 'hr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validate = $request->validate(
            [
                'job_id'                      => 'required',
                'name'                        => 'required | alpha_spaces',
                'email'                       => 'required|email|unique:candidates',
                'dob'                         => 'required|date|before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
                'gender'                      => 'required',
                'phone_number'                => 'required|digits:10|unique:candidates',
                'candidate_location'          => 'required',
                'nationality'                 => 'required',
                'total_experience'            => 'required',
                'relevant_experience'         => 'required',
                'current_position'            => 'required',
                'current_company'             => 'required',
                'notice_period'               => 'nullable',
                'current_ctc'                 => 'required',
                'expected_ctc'                => 'required',
                'negotiation_salary'          => 'required',
                'skills'                      => 'required',
                'graduation_degree'           => 'required',
                'graduation_university'       => 'required',
                'resume_upload'               => 'required|file|max:5000|mimes:pdf,docx,doc',
                'marital_status'              => 'required',
                'client_interaction_location' => 'required',
                'individual_contributor'      => 'required',
                'hybrid_model'                => 'required',
            ],
            $message = [
                'dob.before_or_equal'                   => 'Enter Valid Date Of Birth.',
                'current_position.required'             => 'Current Designation field is required.',
                'client_interaction_location.required'  => 'This field is required.',
                'individual_contributor.required'       => 'This field is required.',
                'hybrid_model.required'                 => 'This field is required.',
            ]
        );




        $resume_path = time() . '.' . $request->resume_upload->extension();
        $request->resume_upload->move(public_path('resume'), $resume_path);

        $candidate = new Candidate();

        $candidate->job_id                      = $request->job_id;
        $candidate->name                        = $request->name;
        $candidate->email                       = $request->email;
        $candidate->dob                         = Carbon::parse($request->dob);
        $candidate->gender                      = $request->gender;
        $candidate->phone_number                = $request->phone_number;
        $candidate->alternate_phone_number      = $request->alternate_phone_number;
        $candidate->candidate_location          = $request->candidate_location;
        $candidate->address                     = $request->address;
        $candidate->nationality                 = $request->nationality;
        $candidate->total_experience            = $request->total_experience;
        $candidate->relevant_experience         = $request->relevant_experience;
        $candidate->current_position            = $request->current_position;
        $candidate->current_company             = $request->current_company;
        $candidate->notice_period               = $request->notice_period;
        $candidate->current_ctc                 = $request->current_ctc;
        $candidate->expected_ctc                = $request->expected_ctc;
        $candidate->negotiation_salary          = $request->negotiation_salary;
        $candidate->skills                      = $request->skills;
        $candidate->language_known              = $request->language_known;
        $candidate->graduation_degree           = $request->graduation_degree;
        $candidate->graduation_university       = $request->graduation_university;
        $candidate->outsourced_via              = $request->outsourced_via;
        $candidate->candidate_created_date      = Carbon::now();
        $candidate->recruiter_name              = $request->recruiter_name;
        $candidate->resume_upload               = $resume_path;
        $candidate->consultancy_id              = $request->consultancy_id;
        $candidate->marital_status              = $request->marital_status;
        $candidate->client_interaction_location = $request->client_interaction_location;
        $candidate->individual_contributor      = $request->individual_contributor;
        $candidate->hybrid_model                = $request->hybrid_model;
        $candidate->save();

        $job_round = Job::where('id', '=', $request->job_id)->select('rounds')->get();

        $interview = new JobInterview();

        $i = 0;
        $k = 1;

        $r = 'round_';


        foreach ($job_round as $j) {

            foreach ($j->rounds as $int) {

                $int_template = InterviewRound::where('id', $int)->select('feedback_template')->first();

                $r1 = $r . '' . $k;

                $interview->$r1 = $int;

                $rt = 'round_' . $k . '_feedback_type';

                $interview->$rt = $int_template->feedback_template;



                $i++;
                $k++;
            }
        }

        $candidate_id = Candidate::with(['consultancy_details', 'job' => function ($j) {

            $j->select('job_code', 'id')->get();
        }, 'employee' => function ($e) {
            $e->select('id', 'name', 'email')->get();
        }])->where('email', '=', $request->email)->first();


        $interview->can_id = $candidate_id->id;

        $interview->job_id = $request->job_id;

        $interview->save();

        $mail_data = $candidate_id;


        $mail_sent = ([

            'can_name' => $mail_data->name,
            'created_by' => null,
            'job_code' => $mail_data->job->job_code,
            'location' => $mail_data->candidate_location,
            'phone_number' => $mail_data->phone_number,
            'agency_name' => $mail_data->consultancy_details->consultancy_name,

        ]);

        Mail::to('a@abc.com')->send(new new_candidate($mail_sent));





        return redirect()->route('consultancy.candidate.index')->with('message', 'Candidate Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $candidate = Candidate::find($id);
        return view('consultancy.candidate.show', compact('candidate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $candidate = Candidate::find($id);

        if ($candidate->consultancy_id == Auth::guard('consultancy')->id()) {

            return view('consultancy.candidate.edit', compact('candidate'));
        } else {
            return redirect()->route('consultancy.candidate.index')->with('error', 'You Are Not Authorised.');
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


        $validate = $request->validate(
            [
                'job_id'                      => 'required',
                'name'                        => 'required | alpha_spaces',
                'email'                       => 'required|email|unique:candidates,email,' . $id,
                'dob'                         => 'required|date|before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
                'gender'                      => 'required',
                'phone_number'                => 'required|digits:10|unique:candidates,phone_number,' . $id,
                'candidate_location'          => 'required',
                'nationality'                 => 'required',
                'total_experience'            => 'required',
                'relevant_experience'         => 'required',
                'current_position'            => 'required',
                'current_company'             => 'required',
                'notice_period'               => 'nullable',
                'current_ctc'                 => 'required',
                'expected_ctc'                => 'required',
                'negotiation_salary'          => 'required',
                'skills'                      => 'required',
                'graduation_degree'           => 'required',
                'graduation_university'       => 'required',
                'resume_upload'               => 'nullable|file|max:5000|mimes:pdf,docx,doc',
                'marital_status'              => 'required',
                'client_interaction_location' => 'required',
                'individual_contributor'      => 'required',
                'hybrid_model'                => 'required',

            ],
            $message = [
                'dob.before_or_equal'                   => 'Enter Valid Date Of Birth.',
                'current_position.required'             => 'Current Designation field is required.',
                'client_interaction_location.required'  => 'This field is required.',
                'individual_contributor.required'       => 'This field is required.',
                'hybrid_model.required'                 => 'This field is required.',
            ]
        );





        $candidate = Candidate::find($id);

        $candidate->job_id                      = $request->job_id;
        $candidate->name                        = $request->name;
        $candidate->email                       = $request->email;
        $candidate->dob                         = Carbon::parse($request->dob);
        $candidate->gender                      = $request->gender;
        $candidate->phone_number                = $request->phone_number;
        $candidate->alternate_phone_number      = $request->alternate_phone_number;
        $candidate->candidate_location          = $request->candidate_location;
        $candidate->address                     = $request->address;
        $candidate->nationality                 = $request->nationality;
        $candidate->total_experience            = $request->total_experience;
        $candidate->relevant_experience         = $request->relevant_experience;
        $candidate->current_position            = $request->current_position;
        $candidate->current_company             = $request->current_company;
        $candidate->notice_period               = $request->notice_period;
        $candidate->current_ctc                 = $request->current_ctc;
        $candidate->expected_ctc                = $request->expected_ctc;
        $candidate->negotiation_salary          = $request->negotiation_salary;
        $candidate->skills                      = $request->skills;
        $candidate->language_known              = $request->language_known;
        $candidate->graduation_degree           = $request->graduation_degree;
        $candidate->graduation_university       = $request->graduation_university;
        $candidate->outsourced_via              = $request->outsourced_via;       
        $candidate->recruiter_name              = $request->recruiter_name;
        $candidate->marital_status              = $request->marital_status;
        $candidate->client_interaction_location = $request->client_interaction_location;
        $candidate->individual_contributor      = $request->individual_contributor;
        $candidate->hybrid_model                = $request->hybrid_model;



        if ($request->hasFile('resume_upload')) {

            $resume_path = time() . '.' . $request->resume_upload->extension();
            $request->resume_upload->move(public_path('resume'), $resume_path);

            $candidate->resume_upload               = $resume_path;
        }

        $candidate->consultancy_id              = $request->consultancy_id;

        $candidate->update();

        return redirect()->route('consultancy.candidate.index')->with('message', 'Candidate Updated Successfully');
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
}
