<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Mail\JobSchedule;
use App\Mail\interviewerjobschedule;
use App\Mail\reschedulemail;
use App\Mail\interviewerjobreschedule;
use Illuminate\Http\Request;
use App\Models\JobInterview;
use App\Models\JobScheduleModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class JobScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {


        $schedule_interview = JobInterview::with([
            'candetails',
            'jobdetails' => function ($j) {

                $j->with('position');
            }
        ])->where('id', '=', $request->id)->first();



        $round = $request->round;

        $round_id = $schedule_interview->$round;
        $roundname = $request->roundname;

        if ($schedule_interview->jobdetails->job_status != 1) {

            return view('hr.interview.page.job_status')->render();
        } else {

            return view('hr.interview.page.job-schedule', compact('schedule_interview', 'round', 'roundname', 'round_id'))->render();
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
        

        $validate = $request->validate(
            [

                'interviewer_id' => 'required',
                'schedule_date' => 'required|date|after:yesterday',
                'schedule_time' => 'required',
                'interview_type' => 'required',

            ],
            $message = [
                'interviewer_id.required' => 'The interviewer name field is required.',
                'schedule_date.required' => 'The interview date field is required',
                'schedule_time.required' => 'The interview time field is required',

            ]
        );


        $data = new JobScheduleModel;

        $data->job_id = $request->job_id;
        $data->round  = $request->round;
        $data->interviewer_id = $request->interviewer_id;
        $data->interviewer_2_id = $request->interviewer_2_id;
        $data->can_id = $request->can_id;
        $data->schedule_date = Carbon::parse($request->schedule_date);
        $data->schedule_time = Carbon::parse($request->schedule_time);
        $data->interview_type = $request->interview_type;
        $data->meeting_link =   $request->meeting_link;
        $data->job_interview_id = $request->job_interview;
        $data->round_id = $request->round_id;
        $data->save();

        $suffix = '_status';
        $round = $request->round . $suffix;

        $status = JobInterview::find($request->job_interview);

        $status->$round = 0;

        $status->update();

        // mail details //  

        $mail_send = JobScheduleModel::with([
            'rounddetails', 'candetails',

            'jobdetails' => function ($j) {

                $j->with('user');
            }
        ])->where('id', $data->id)->first();

		if(!empty($mail_send->interviewer_2_id)){
			$mail_data = ([

            'schedule_date' => Carbon::parse($mail_send->schedule_date)->format('d-m-Y'),
            'schedule_time' => Carbon::parse($mail_send->schedule_time)->format('d-m-Y'),
            'round' => substr($request->round, strpos($request->round, "_") + 1),
            'round_id' => $mail_send->rounddetails->round_name,
            'interview_type' => $mail_send->interview_type,
            'url' => $mail_send->meeting_link,
            'can_name' => $mail_send->candetails->name,
            'interviewer_name' => $mail_send->employee->name,
            'interviewer_2_name' => $mail_send->interviewer->name,
            'job_code'  =>  $mail_send->jobdetails->job_code,

        ]);
		}
		else{
			$mail_data = ([

            'schedule_date' => Carbon::parse($mail_send->schedule_date)->format('d-m-Y'),
            'schedule_time' => Carbon::parse($mail_send->schedule_time)->format('d-m-Y'),
            'round' => substr($request->round, strpos($request->round, "_") + 1),
            'round_id' => $mail_send->rounddetails->round_name,
            'interview_type' => $mail_send->interview_type,
            'url' => $mail_send->meeting_link,
            'can_name' => $mail_send->candetails->name,
            'interviewer_name' => $mail_send->employee->name,            
            'job_code'  =>  $mail_send->jobdetails->job_code,

        ]);
		}

        

        Mail::to($mail_send->candetails->email)->send(new JobSchedule($mail_data));

if(!empty($mail_send->interviewer_2_id)){
        foreach ([$mail_send->employee->email, $mail_send->interviewer->email] as $recipient) {
            Mail::to($recipient)->send(new interviewerjobschedule($mail_data));
        }
}else{
	
            Mail::to($mail_send->employee->email)->send(new interviewerjobschedule($mail_data));
        
}

        Mail::to($mail_send->jobdetails->user->email)->send(new JobSchedule($mail_data));

        return response()->json(['success' => 'Job Position saved successfully.']);
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
        $validate = $request->validate(
            [
                'job_id' => 'required',
                'round' => 'required',
                'interviewer_id' => 'required',
                'can_id' => 'required',
                'schedule_date' => 'required|date | after:yesterday',
                'schedule_time' => 'required',
                'interview_type' => 'required',

            ],
            $message = [
                'interviewer_id.required' => 'The interviewer name field is required.'
            ]
        );
        $data = JobScheduleModel::find($id);

        $data->job_id = $request->job_id;
        $data->round  = $request->round;
        $data->interviewer_id = $request->interviewer_id;
        $data->interviewer_2_id = $request->interviewer_2_id;
        $data->can_id = $request->can_id;
        $data->schedule_date = Carbon::parse($request->schedule_date);
        $data->schedule_time = Carbon::parse($request->schedule_time);
        $data->interview_type = $request->interview_type;
        $data->meeting_link =   $request->meeting_link;
        $data->round_id = $request->round_id;
        $data->update();

        $mail_send = JobScheduleModel::with([
            'rounddetails', 'candetails',

            'jobdetails' => function ($j) {

                $j->with('user');
            }
        ])->where('id', $data->id)->first();

        	if(!empty($mail_send->interviewer_2_id)){
			$mail_data = ([

            'schedule_date' => Carbon::parse($mail_send->schedule_date)->format('d-m-Y'),
            'schedule_time' => Carbon::parse($mail_send->schedule_time)->format('d-m-Y'),
            'round' => substr($request->round, strpos($request->round, "_") + 1),
            'round_id' => $mail_send->rounddetails->round_name,
            'interview_type' => $mail_send->interview_type,
            'url' => $mail_send->meeting_link,
            'can_name' => $mail_send->candetails->name,
            'interviewer_name' => $mail_send->employee->name,
            'interviewer_2_name' => $mail_send->interviewer->name,
            'job_code'  =>  $mail_send->jobdetails->job_code,

        ]);
		}
		else{
			$mail_data = ([

            'schedule_date' => Carbon::parse($mail_send->schedule_date)->format('d-m-Y'),
            'schedule_time' => Carbon::parse($mail_send->schedule_time)->format('d-m-Y'),
            'round' => substr($request->round, strpos($request->round, "_") + 1),
            'round_id' => $mail_send->rounddetails->round_name,
            'interview_type' => $mail_send->interview_type,
            'url' => $mail_send->meeting_link,
            'can_name' => $mail_send->candetails->name,
            'interviewer_name' => $mail_send->employee->name,            
            'job_code'  =>  $mail_send->jobdetails->job_code,

        ]);
		}



        Mail::to($mail_send->candetails->email)->send(new reschedulemail($mail_data));

        if(!empty($mail_send->interviewer_2_id)){
        foreach ([$mail_send->employee->email, $mail_send->interviewer->email] as $recipient) {
            Mail::to($recipient)->send(new interviewerjobschedule($mail_data));
        }
}else{
	
            Mail::to($mail_send->employee->email)->send(new interviewerjobschedule($mail_data));
        
}        

        Mail::to($mail_send->jobdetails->user->email)->send(new reschedulemail($mail_data));


        return response()->json(['success' => 'Job Position Updated successfully.']);
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

    public function re_schedule(Request $request)
    {

        $round = $request->round;
        $roundname = $request->roundname;

        $reschedule_interview =  JobScheduleModel::with([
            'jobdetails', 'candetails', 'jobinterview' => function ($c) {
                $c->select('id');
            }, 'interviewer' => function ($i) {
                $i->select('id', 'name');
            },'employee' => function($e){
                $e->select('id','name');
            }
        ])->where('job_id', '=', $request->job)
            ->where('can_id', '=', $request->id)
            ->where('round', '=', $round)->first();

        if ($reschedule_interview->jobdetails->job_status != 1) {
            return view('hr.interview.page.job_status')->render();
        } else {
            return view('hr.interview.page.job-reschedule', compact('reschedule_interview', 'round', 'roundname'))->render();
        }
    }
}
