<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Mail\ConsultancyJobShare;
use App\Mail\JobShare;
use App\Mail\JobUpdate;
use App\Models\Agency;
use App\Models\Job;
use App\Models\JobPosition;
use App\Models\JobType;
use App\Models\SkillSet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hr.job.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $job_type = JobType::all();
        $job_position = JobPosition::where('status', '=', '1')->get();
        $skill = SkillSet::all();
        $hr = User::where('sub_role', '=', 'hr')->select('id', 'name','last_name')->get();

        return view('hr.job.create', compact('job_type', 'job_position', 'hr', 'skill'));
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

                'position_id'           => 'required',
                'project_id'            => 'required',
                'candidate_type'        => 'required',
                'job_type_id'           => 'required',
                'headcount'             => 'required',
                'minimum_salary'        => 'required',
                'maximum_salary'        => 'required',
                'currency'              => 'required | alpha',
                'experience_required'   => 'required',
                'importance'            => 'required',
                'job_posted_date'       => 'required |date| after_or_equal:' . \Carbon\Carbon::now()->format('Y-m-d'),
                'job_owner'             => 'required',
                'job_description'       => 'required',
                'essential_skills'      => 'required | not_in:desirable_skills',
                'desirable_skills'      => 'nullable | not_in:essential_skills',
                'jd_upload'             => 'nullable|file|max:5000|mimes:pdf,docx,doc',
                'received_date'         => 'date | nullable',
                'submit_date'           => 'date | nullable',
                'closed_date'           => 'date | nullable |after_or_equal:received_date',

            ],
            $message = [
                'position_id.required'              =>  'The position name field is required',
                'project_id.required'               =>  'The project field is required',
                'job_type_id.required'              =>  'The job type field is required',
                'job_posted_date.after_or_equal'    =>  'The job posted date must be a date after or equal to today.'
            ]
        );
        if ($request->jd_upload != null) {
            $jd_path = time() . '.' . $request->jd_upload->extension();
            $request->jd_upload->move(public_path('jd'), $jd_path);
        } else {
            $jd_path = null;
        }

        $essential_skills = $request->essential_skills;
        $essential_skills = array_map('intval', $essential_skills);

        if ($request->desirable_skills != null) {
            $desirable_skills = $request->desirable_skills;
            $desirable_skills = array_map('intval', $desirable_skills);


            $check_duplicate_skills = array_intersect($essential_skills, $desirable_skills);
            if ($check_duplicate_skills != null) {
                return back()->with('error2', 'Skill set must be different.');
            }
        } else {
            $desirable_skills = null;
        }



        $job = new Job;

        $job->position_id           = $request->position_id;
        $job->project_id            = $request->project_id;
        $job->candidate_type        = $request->candidate_type;
        $job->location              = $request->location;
        $job->job_type_id           = $request->job_type_id;
        $job->headcount             = $request->headcount;
        $job->minimum_salary        = $request->minimum_salary;
        $job->maximum_salary        = $request->maximum_salary;
        $job->currency              = $request->currency;
        $job->billing_mode          = $request->billing_mode;
        $job->experience_required   = $request->experience_required;
        $job->importance            = $request->importance;
        $job->job_posted_date       = Carbon::parse($request->job_posted_date);
        $job->job_owner             = $request->job_owner;
        $job->job_description       = $request->job_description;
        $job->essential_skills      = $essential_skills;
        $job->desirable_skills      = $desirable_skills;
        $job->jd_upload             = $jd_path;
        $job->created_by            = Auth::user()->id;
        $job->received_date         = Carbon::parse($request->received_date);
        $job->closed_date           = Carbon::parse($request->closed_date);
        $job->submit_date           = Carbon::parse($request->submit_date);
        $job->wo_id                 = $request->wo_id;
        $job->save();

        return redirect()->route('job.index')->with('message', 'Job Created Successfully');
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
        $job_type = JobType::all();
        $job_position = JobPosition::where('status', '=', '1')->get();
        $hr = User::where('sub_role', '=', 'hr')->select('id', 'name','last_name')->get();
        $skill = SkillSet::all();
        $job = Job::find($id);
        return view('hr.job.edit', compact('job', 'job_type', 'job_position', 'hr', 'skill'));
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
        $job = Job::find($id);

        $validate = $request->validate([

            'position_id'           => 'required',
            'project_id'            => 'required',
            'candidate_type'        => 'required',
            'job_type_id'           => 'required',
            'headcount'             => 'required',
            'minimum_salary'        => 'required',
            'maximum_salary'        => 'required',
            'currency'              => 'required | alpha',
            'experience_required'   => 'required',
            'importance'            => 'required',
            'job_posted_date'       => 'required |date| after_or_equal:' . \Carbon\Carbon::parse($job->job_posted_date)->format('Y-m-d'),
            'job_owner'             => 'required',
            'job_description'       => 'required',
            'received_date'         => 'date | nullable',
            'submit_date'           => 'date | nullable',
            'closed_date'           => 'date | nullable |after_or_equal:' . \Carbon\Carbon::parse($job->closed_date)->format('Y-m-d'),
            'essential_skills'      => 'required | not_in:desirable_skills',
            'desirable_skills'      => 'nullable | not_in:essential_skills',
            'jd_upload'             => 'nullable|file|max:5000|mimes:pdf,docx,doc',

        ], $message = [
            'position_id.required'  =>  'The position name field is required',
            'project_id.required'   =>  'The project field is required',
            'job_type_id.required'  =>  'The job type field is required'
        ]);


        $essential_skills = $request->essential_skills;
        $essential_skills = array_map('intval', $essential_skills);


        if ($request->desirable_skills != null) {
            $desirable_skills = $request->desirable_skills;
            $desirable_skills = array_map('intval', $desirable_skills);
            $check_duplicate_skills = array_intersect($essential_skills, $desirable_skills);
            if ($check_duplicate_skills != null) {
                return back()->with('error2', 'Skill set must be different.');
            }
        } else {
            $desirable_skills = null;
        }
               

        if ($request->jd_upload != null) {
            $jd_path = time() . '.' . $request->jd_upload->extension();
            $request->jd_upload->move(public_path('jd'), $jd_path);
            $job->jd_upload         = $jd_path;
        }

        $job->position_id           = $request->position_id;
        $job->project_id            = $request->project_id;
        $job->candidate_type        = $request->candidate_type;
        $job->location              = $request->location;
        $job->job_type_id           = $request->job_type_id;
        $job->headcount             = $request->headcount;
        $job->minimum_salary        = $request->minimum_salary;
        $job->maximum_salary        = $request->maximum_salary;
        $job->currency              = $request->currency;
        $job->billing_mode          = $request->billing_mode;
        $job->experience_required   = $request->experience_required;
        $job->importance            = $request->importance;
        $job->job_posted_date       = Carbon::parse($request->job_posted_date);
        $job->job_owner             = $request->job_owner;
        $job->job_description       = $request->job_description;
        $job->essential_skills      = $essential_skills;
        $job->desirable_skills      = $desirable_skills;
        $job->updated_by            = Auth::user()->id;
        $job->received_date         = Carbon::parse($request->received_date);
        $job->closed_date           = Carbon::parse($request->closed_date);
        $job->submit_date           = Carbon::parse($request->submit_date);
        $job->wo_id                 = $request->wo_id;
        $job->update();


        $shared = $job->consultancy_refer;

        $share = [

            'name' => $job->position->position_name,
            'code' => $job->job_code,
            'id' => $job->id,

        ];

        if ($shared != null) {
            foreach ($shared as $con) {
                $consultancy = Agency::find($con);
                Mail::to($consultancy->email)->send(new JobUpdate($share));
            }
        }

        return redirect()->route('job.index')->with('message', 'Job Updated Successfully');
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


    public function sharemail(Request $request)
    {

        $job_details = Job::with('position')->find($request->id);
        $emp_mail = Config::get('constants.swordgroupmail.mail');

        $share = [

            'name' => $job_details->position->position_name,
            'code' => $job_details->job_code,
            'id' => $job_details->id,

        ];


        if (($request->emp_refer == 0 || $request->emp_refer == 1) && $request->emp_refer != null) {

            $job_details->emp_refer = $request->emp_refer;
        }

        if ($request->emp_show) {

            $job_details->emp_show = $request->emp_show;
        }

        if (!empty($request->consultancy_id)) {

            $shared = array_map('intval', request('consultancy_id'));
        } else {

            $shared = null;
        }

        if (!empty($job_details->consultancy_refer) && $shared != null) {

            $shared_array = array_merge($shared, $job_details->consultancy_refer);

            $job_details->consultancy_refer = $shared_array;
        } elseif ($shared != null) {

            $job_details->consultancy_refer = $shared;
        }

        if ($request->emp_refer == 1 &&  $job_details->emp_refer == 0) {

            Mail::to($emp_mail)->send(new JobShare($share));
        }

        $job_details->update();


        if ($shared != null) {
            foreach ($shared as $con) {
                $consultancy = Agency::find($con);
                Mail::to($consultancy->email)->send(new ConsultancyJobShare($share));
            }
        }

        return redirect()->route('job.index')->with('message', 'Job Shared Successfully');
    }
}
