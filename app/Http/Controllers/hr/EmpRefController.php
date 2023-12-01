<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmpRefController extends Controller
{

   public function index()
   {
      return view('hr.referral.index');
   }

   public function ack($id)
   {
      $job = Job::with('position', 'job_type')->find($id);
      
      return view('hr.referral.emp_refer', compact('job'));
   }

   public function emp_ack_reply(Request $request, $id)
   {

      $user_id = Auth::id();
      $job = Job::find($id);

      $checkpivot = $job->userpivot()->where('id', $user_id)->exists();         

      if ($checkpivot == false) {

         $job->userpivot()->attach([$user_id => ['ack' => $request->ack]]);
         return redirect()->route('emp-referral')->with('message2', 'Acknowledge Saved Successfully');

      } else {

         $job->userpivot()->updateExistingPivot($user_id, ['ack' => $request->ack]);
         return redirect()->route('emp-referral')->with('message2', 'Acknowledge Updated Successfully');
         
      }

      return back()->with('message', 'Something Went Wrong.');
   }
}
