<?php

namespace App\Http\Controllers\consultancy;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Job;
use App\Models\SkillSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultancyRefController extends Controller
{
    public function index()
    {
        return view('consultancy.referral.index');
    }

    public function ack($id)
    {
        $job = Job::with(['position' => function ($p) {
            $p->select('id', 'position_name');
        }, 'job_type' => function ($j) {
            $j->select('id', 'job_type');
        }, 'user' => function ($u) {
            $u->select('id', 'name');
        }])->find($id);

        $job_essential_skill = $job->essential_skills;
        $job_desirable_skill = $job->desirable_skills;

        $essential_skills = SkillSet::whereIn('id', $job_essential_skill)->select('id', 'skillset')->get();
     if($job_desirable_skill != null){ 
       $desirable_skills = SkillSet::whereIn('id', $job_desirable_skill)->select('id', 'skillset')->get();
     }else{
         
         $desirable_skills = null;
     }

        $consultancy_id = Auth::guard('consultancy')->id();
        $checkpivot = $job->consultancypivot()->where('id', $consultancy_id);
        $ack = $checkpivot->select('id')->first();


        if ($ack != null) {

            if ($ack->pivot->ack == 1) {
                return redirect()->route('consultancy.referral')->with('message2', 'Acknowledgement Already Submitted.');
            }
            else{
                return view('consultancy.referral.con_refer', compact('job', 'essential_skills', 'desirable_skills'));
            }
        } else {
            return view('consultancy.referral.con_refer', compact('job', 'essential_skills', 'desirable_skills'));
        }

        if (!empty($job)) {
            if ($job->job_status !=  1) {
                return redirect()->route('consultancy.referral')->with('error', 'This Job Vacancy is not in active status, Please Contact HR Team ');
            }
        } else {
            return redirect()->route('consultancy.referral')->with('error', 'Job Vacancy Does Not Exist');
        }
        
    }

    public function con_ack_reply(Request $request, $id)
    {

        $consultancy_id = Auth::guard('consultancy')->id();
        $job = Job::find($id);

        $checkpivot = $job->consultancypivot()->where('id', $consultancy_id);
        $ack = $checkpivot->select('id')->first();

        if ($checkpivot->exists() == false) {

            $job->consultancypivot()->attach([$consultancy_id => ['ack' => $request->ack]]);
            if ($request->ack == '1') {
                return redirect()->route('consultancy.referral')->with('message2', 'Acknowledge Saved Successfully, Start Creating Canditate Now !!!');
            } else {
                return redirect()->route('consultancy.referral')->with('message2', 'Acknowledge Saved Successfully.');
            }
        } else {
            if ($ack->pivot->ack == 1) {
                return redirect()->route('consultancy.referral')->with('message2', 'Acknowledgement Already Submitted.');
            } else {
                $job->consultancypivot()->updateExistingPivot($consultancy_id, ['ack' => $request->ack]);
                return redirect()->route('consultancy.referral')->with('message2', 'Acknowledge Updated Successfully');
            }
        }

        return back()->with('message', 'Something Went Wrong.');
    }

    public function conHome()
    {

        $candidate = Candidate::where('consultancy_id', Auth::guard('consultancy')->id())->select('id', 'job_id')->orderBy('job_id', 'DESC')->get();

        $job_id = array();

        foreach ($candidate as $can) {
            $job_id[] = $can->job_id; // Get unique country by code.
        }

        $candidate_count = array_count_values($job_id);
        $c = array_values($candidate_count);

        $jobs = Job::whereIn('id', array_unique($job_id))->with(['position' => function ($p) {
            $p->select('id', 'position_name');
        }])->select('job_code', 'position_id', 'id')->orderBy('id', 'DESC')->get();

        $job_code = array();
        $can_list = [];

        if ($jobs->isNotEmpty()) {
            foreach ($jobs as $job) {
                $job_code[] = $job->job_code; // Get unique country by code.
            }

            foreach ($jobs as $job) {
                $can_list[$job->id] = Candidate::where('job_id', $job->id)->where('consultancy_id', Auth::guard('consultancy')->id())->select('name')->get();
            }
        }


        return view('consultancy.home', compact('c', 'job_code', 'jobs', 'can_list'));
    }
}
