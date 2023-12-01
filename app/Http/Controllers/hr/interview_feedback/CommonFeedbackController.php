<?php

namespace App\Http\Controllers\hr\interview_feedback;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobScheduleModel;
use App\Models\InterviewRound;
use App\Models\CommonInterviewFeedback;
use App\Models\JobInterview;
use App\Models\TechFeedbackModel;
use App\Models\CommmonFeedbackModel;
use App\Models\SkillSet;
use Illuminate\Support\Facades\Auth;
use App\Mail\feedback_submitted;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class CommonFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function common_feedback_form($id){


         $candidate = JobScheduleModel::with(['jobdetails'=>function($j){
            $j->with(['position'=>function($p){
                $p->select('id','position_name');
            }])->select('id','job_code','position_id','essential_skills','desirable_skills');

        } ,'candetails','jobinterview'])->where('id','=',$id)->where('status','=',1)->first();

          $schedule_id = $id;
    if($candidate && $candidate->interviewer_id == Auth::id() )
        { 

          $current_round = $candidate->round;

          $roundname = InterviewRound::get();

          $round_number =substr($current_round, strpos($current_round, "_") + 1);

              return view('hr.interview_feedback.common_feedback',
                    compact('candidate','roundname','round_number','current_round','schedule_id'));
             
   
      }else{

            return redirect()->back()->with('error', 'Interview Inactive '); 


    }


    }
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

            
            'comments' => 'required',
            'status'    => 'required',  
        ]);

        if($request->can_image){

           $validate = $request->validate([

             'can_image'  => 'mimes:jpeg,png,jpg|max:2048',
              ]);


              $can_image = time() . '.' . $request->can_image->extension();

              $request->can_image->move(public_path('interview_image'), $can_image);

  
        }else{

            $can_image = Null;

        }

        $feedback = new CommonInterviewFeedback();

        $feedback->can_id = $request->can_id;
        $feedback->job_id = $request->job_id;
        $feedback->round = $request->current_round;
        $feedback->comment = $request->comments;
        $feedback->can_image = $can_image;
        $feedback->schedule_id = $request->schedule_id;

        $feedback->save();

        $feedback_ref = $feedback->id;

        $current_round = $request->current_round.'_feedback';


         $r_status = $request->current_round.'_status';

 
         $job_update = JobInterview::find($request->job_interview_id);

          

         $job_update->$current_round = $feedback_ref;

          $job_update->$r_status = $request->status;

         $job_update->update();

         $schedule_update = JobScheduleModel::find($request->schedule_update);

         $schedule_update->status = 0;

         $schedule_update->update();


         $mail_send = JobScheduleModel::with([
            'rounddetails', 'candetails',

            'jobdetails' => function ($j) {

                $j->with('user');
            }
        ])->where('id', $request->schedule_id)->first();



        $mail_data = ([

            'schedule_date' => Carbon::parse($mail_send->schedule_date)->format('d-m-Y'),
            'schedule_time' => Carbon::parse($mail_send->schedule_time)->format('d-m-Y'),
            'round' => substr($request->round, strpos($request->round, "_") + 1),
            'round_id' => $mail_send->rounddetails->round_name,
            'interview_type' => $mail_send->interview_type,
            'can_name' => $mail_send->candetails->name,
            'interviewer_name' => $mail_send->employee->name,
            'job_id'=>  $request->job_id,
  
        ]);

          
        

        Mail::to($mail_send->jobdetails->user->email)->send(new feedback_submitted($mail_data));


         return redirect()->route('interviewer')->with('message', 'Feedback Saved Successfully');




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
        //
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
        //
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
