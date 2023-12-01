<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\InterviewRound;
use App\Models\Job;
use App\Models\JobInterview;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Mail\new_candidate;

use Illuminate\Support\Facades\Mail;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hr.candidate.index');
    }

    public function candidate_index($id)
    {
        $candidate = Candidate::where('job_id', '=', $id)->where('referred_by', '=', Auth::id())->get();

        return datatables($candidate)->addIndexColumn()
            ->addColumn('action', function ($row) {

                $action = '<a  href="candidate/' . $row->id . '/edit ">
                          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                          stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
                          <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
                          <line x1="3" y1="22" x2="21" y2="22"></line></svg></a>';

                return $action;
            })


            ->rawColumns(['action'])
            ->addColumn('job_code', function ($row) {
                return $row->job->job_code;
            })


            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $job = Job::get();
        return view('hr.candidate.create', compact('job'));
    }

    public function catcreate($id)
    {

        $job = Job::with(['position', 'project', 'user'])->where('id', $id)->first();

        if ($job->rounds != null) {

            $hr = User::where('sub_role', '=', 'hr')->where('employee_status','=',1)->select('id', 'name','last_name')->get();

            $user_id = Auth::id();

            return view('hr.candidate.create', compact('job', 'hr'));
        } else {
            if (Auth::user()->role == 'super_admin' || Auth::user()->sub_role == 'hr') {
                return redirect()->route('job.index')->with('error', 'Create Interview Rounds Before Candidate Create');
            } else {
                return redirect()->route('emp-referral')->with('error2', 'Something Went Wrong | Contact HR Team');
            }
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (Auth::user()->role == 'super_admin' || Auth::user()->sub_role == 'hr') {

            $validate = $request->validate(
                [
                    'job_id'                      => 'required',
                    'name'                        => 'required',
                    'email'                       => 'required|email|unique:candidates',
                    'dob'                         => 'required|date|before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
                    'gender'                      => 'required',
                    'phone_number'                => 'required|digits:10|unique:candidates',
                    'candidate_location'          => 'required',
                    'address'                     => 'required',
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
                    'language_known'              => 'required',
                    'graduation_degree'           => 'required',
                    'graduation_university'       => 'required',
                    'resume_upload'               => 'required|file|max:5000|mimes:pdf,docx,doc',
                    'outsourced_via'              => 'required',
                    'recruiter_name'              => 'required',
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
        }
        if (Auth::user()->role == 'project_manager' || Auth::user()->role == 'employee') {

            $validate = $request->validate(
                [
                    'job_id'                      => 'required',
                    'name'                        => 'required|alpha_spaces',
                    'email'                       => 'required|email|unique:candidates',
                    'dob'                         => 'nullable|date|before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
                    'gender'                      => 'required',
                    'phone_number'                => 'required|digits:10|unique:candidates',
                    'resume_upload'               => 'required|file|max:5000|mimes:pdf,docx,doc',
                    'marital_status'              => 'required',
                ],
                $message = [
                    'dob.before_or_equal'         => 'Enter Valid Date Of Birth.',

                ]
            );
        }


        $resume_path = time() . '.' . $request->resume_upload->extension();
        $request->resume_upload->move(public_path('resume'), $resume_path);

        $candidate = new Candidate;

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
        $candidate->referred_by                 = $request->referred_by;
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

        $candidate_id = Candidate::with(['job' => function ($j) {

            $j->with(['user' => function ($u) {
                $u->select('id', 'email');
            }])->select('job_code', 'id', 'job_owner')->get();
        }, 'employee' => function ($e) {
            $e->select('id', 'name', 'email')->get();
        }])->where('email', '=', $request->email)->first();



        $interview->can_id = $candidate_id->id;

        $interview->job_id = $request->job_id;

        $interview->save();

        $mail_data = $candidate_id;

        if ($mail_data->referred_by == null) {
            $mail_sent = ([

                'can_name' => $mail_data->name,
                'created_by' => $mail_data->employee->name,
                'job_code' => $mail_data->job->job_code,
                'location' => $mail_data->candidate_location,
                'phone_number' => $mail_data->phone_number,
                'agency_name' => null,

            ]);

            Mail::to($mail_data->employee->email)->send(new new_candidate($mail_sent));
        } else {

            $refer_by = User::where('employee_code', '=', $mail_data->referred_by)->select('name')->first();

            $mail_sent = ([

                'can_name' => $mail_data->name,
                'created_by' => $refer_by->name,
                'job_code' => $mail_data->job->job_code,
                'location' => $mail_data->candidate_location,
                'phone_number' => $mail_data->phone_number,
                'agency_name' => null,

            ]);

            Mail::to($mail_data->job->user->email)->send(new new_candidate($mail_sent));
        }

        return redirect()->route('candidate.index')->with('message', 'Candidate Created Successfully');
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
        return view('hr.candidate.show', compact('candidate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $candidate = Candidate::with('job')->find($id);
        $hr = User::where('sub_role', '=', 'hr')->where('employee_status','=',1)->select('id', 'name','last_name')->get();
        $job = Job::with(['position', 'project', 'user'])->where('id', $candidate->job_id)->first();

        return view('hr.candidate.edit', compact('candidate', 'hr', 'job'));
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

        if (Auth::user()->role == 'super_admin' || Auth::user()->sub_role == 'hr') {

            $validate = $request->validate(
                [
                    'job_id'                      => 'required',
                    'name'                        => 'required | alpha_spaces',
                    'email'                       => 'required|email|unique:candidates,email,' . $id,
                    'dob'                         => 'required|date|before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
                    'gender'                      => 'required',
                    'phone_number'                => 'required|digits:10|unique:candidates,phone_number,' . $id,
                    'candidate_location'          => 'required',
                    'address'                     => 'required',
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
                    'language_known'              => 'required',
                    'graduation_degree'           => 'required',
                    'graduation_university'       => 'required',
                    'outsourced_via'              => 'required',
                    'recruiter_name'              => 'required',
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
        }
        if (Auth::user()->role == 'project_manager' || Auth::user()->role == 'employee') {

            $validate = $request->validate(
                [
                    'job_id'                      => 'required',
                    'name'                        => 'required|alpha_spaces',
                    'email'                       => 'required|email|unique:candidates,email,' . $id,
                    'dob'                         => 'required|date|before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
                    'gender'                      => 'required',
                    'phone_number'                => 'required|digits:10|unique:candidates,phone_number,' . $id,
                    'resume_upload'               => 'nullable|file|max:5000|mimes:pdf,docx,doc',
                    'marital_status'              => 'required',
                ],
                $message = [
                    'dob.before_or_equal'         => 'Enter Valid Date Of Birth.',

                ]
            );
        }


        $candidate = Candidate::find($id);

        if ($request->resume_upload != null) {
            $resume_path = time() . '.' . $request->resume_upload->extension();
            $request->resume_upload->move(public_path('resume'), $resume_path);
            $candidate->resume_upload               = $resume_path;
        }

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
        $candidate->referred_by                 = $request->referred_by;
        $candidate->marital_status              = $request->marital_status;
        $candidate->client_interaction_location = $request->client_interaction_location;
        $candidate->individual_contributor      = $request->individual_contributor;
        $candidate->hybrid_model                = $request->hybrid_model;

        $candidate->update();

        return redirect()->route('candidate.index')->with('message', 'Candidate Updated Successfully');
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
