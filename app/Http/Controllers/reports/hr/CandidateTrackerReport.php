<?php

namespace App\Http\Controllers\reports\hr;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobInterview;
use App\Models\JobOffer;
use App\Models\JobPosition as ModelsJobPosition;
use App\Models\JobScheduleModel;
use App\Models\Projectmaster;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CandidateTrackerReport extends Controller
{
    public function candidateTrackerReport(Request $request)
    {
       
        $position = ModelsJobPosition::select('position_name', 'id')->get();
        $project = Projectmaster::select('id', 'project_name')->get();
        $hr = User::where('sub_role', 'hr')->select('name', 'id', 'employee_code')->get();
        $scheduled_interviewer_id = JobScheduleModel::pluck('interviewer_id')->toArray();
        $interviewer = User::whereIn('id', array_unique($scheduled_interviewer_id))->select('id', 'name', 'employee_code')->get();
        $job = Job::select('id', 'job_code')->get();        

        if (request()->ajax()) {            
           //only project
            if($request->ol == null && $request->appointed == null && $request->offer_ack == null &&  $request->project != null && $request->job_code == null && $request->position == null && $request->hr == null && $request->interviewer == null){
                $job=Job::where('project_id','=',(int)$request->project)->pluck('id')->toArray();
                $data = JobInterview::whereIn('job_id',$job)->get();               
            }
            //only job_code
            elseif($request->ol == null && $request->appointed == null && $request->offer_ack == null &&  $request->project == null && $request->job_code != null && $request->position == null && $request->hr == null && $request->interviewer == null){                
                $data = JobInterview::where('job_id','=',(int)$request->job_code)->get();
            }
            //only position
            elseif($request->ol == null && $request->appointed == null && $request->offer_ack == null &&  $request->project == null && $request->job_code == null && $request->position != null && $request->hr == null && $request->interviewer == null){   
                $job=Job::where('position_id','=',(int)$request->position)->pluck('id')->toArray();      
                
                $data = JobInterview::whereIn('job_id',$job)->get();
            }
            //only hr
            elseif($request->ol == null && $request->appointed == null && $request->offer_ack == null &&  $request->project == null && $request->job_code == null && $request->position == null && $request->hr != null && $request->interviewer == null){
                $job=Job::where('job_owner','=',(int)$request->hr)->pluck('id')->toArray();             
                $data = JobInterview::whereIn('job_id',$job)->get();
            }
            //only interviewer
            elseif($request->ol == null && $request->appointed == null && $request->offer_ack == null && $request->project == null && $request->job_code == null && $request->position == null && $request->hr == null && $request->interviewer != null){
                $schedule =JobScheduleModel::where('interviewer_id','=',(int)$request->interviewer)->pluck('can_id')->toArray();   
                $data = JobInterview::whereIn('can_id',$schedule)->get();
            }           
            //only offer Letter
            elseif($request->ol != null && $request->appointed == null && $request->offer_ack == null && $request->project == null && $request->job_code == null && $request->position == null && $request->hr == null && $request->interviewer == null){
                $offerletter =JobOffer::where('offer_letter',$request->ol)->pluck('can_id')->toArray();
                $data = JobInterview::whereIn('can_id',$offerletter)->get();
            }           
            //only offer Ack
            elseif($request->ol == null && $request->appointed == null && $request->offer_ack != null && $request->project == null && $request->job_code == null && $request->position == null && $request->hr == null && $request->interviewer == null){
                $offerack =JobOffer::where('offer_letter',$request->offer_ack)->pluck('can_id')->toArray();
                $data = JobInterview::whereIn('can_id',$offerack)->get();
            }           
            //only appointed
            elseif($request->ol == null && $request->appointed != null && $request->offer_ack == null && $request->project == null && $request->job_code == null && $request->position == null && $request->hr == null && $request->interviewer == null){
                $appointed =JobOffer::where('offer_letter',$request->appointed)->pluck('can_id')->toArray();
                $data = JobInterview::whereIn('can_id',$appointed)->get();
            }
            else{
                $data = JobInterview::get();
            }
          

            return datatables($data)

                ->addIndexColumn()
                
                ->addColumn('name', function ($post) {
                    return $post->candetails->name;
                })
                ->addColumn('candidate_created_date', function ($post) {
                    return $post->candetails->candidate_created_date;
                })
                ->addColumn('job_code', function ($post) {
                    return $post->candetails->job->job_code;
                })
                ->addColumn('project', function ($post) {
                    return $post->candetails->job->project->project_name;
                })
                ->addColumn('position', function ($post) {
                    return $post->candetails->job->position->position_name;
                })
                ->addColumn('recruiter_name', function ($post) {                
                    return $post->candetails->job->user->name;
                })
                ->addColumn('tot_exp', function ($post) {                
                    return $post->candetails->total_experience;
                })
                ->addColumn('rev_exp', function ($post) {                
                    return $post->candetails->relevant_experience;
                })
                ->addColumn('current_company', function ($post) {                
                    return $post->candetails->current_company;
                })
                ->addColumn('current_company_location', function ($post) {                
                    return $post->candetails->candidate_location;
                })
                ->addColumn('notice_period', function ($post) {                
                    return $post->candetails->notice_period;
                })
                ->addColumn('exp_ctc', function ($post) {                
                    return $post->candetails->expected_ctc;
                })
                ->addColumn('cur_ctc', function ($post) {                
                    return $post->candetails->current_ctc;
                })
                ->addColumn('round_1', function ($post) { 
                    if($post->round_1 != null){
                        $round_1 = $post->roundname1->round_name;
                    }else{
                        $round_1='';
                    }               
                    return $round_1;
                })
                ->addColumn('round_1_status', function ($post) {     
                    if($post->round_1 != null && $post->round_1_status != null){

                        $round_1_status = $post->round_1_status;
                        switch($round_1_status){
                            case(1):
                                $status = 'Scheduled';
                                break;
                            case(2):
                                $status = 'Selected';
                                break;
                            case(3):
                                $status = 'Rejected';
                                break;
                        }                  

                    }
                    else{
                        $status='';
                    }             
                    return $status;
                })
                ->addColumn('round_1_int', function ($post) {     
                    if($post->round_1 != null && $post->round_1_status != null){
                        $interviewer= JobScheduleModel::where('can_id','=',$post->can_id)->where('round','=','round_1')->select('interviewer_id')->first();  
                        if(!empty($interviewer)){
                            $int= $interviewer->employee->name; 
                        }
                        else{
                            $int='';
                        }
                             
                    }else{
                        $int='';
                    }
                    return $int;
                })
                ->addColumn('round_2', function ($post) { 
                    if($post->round_2 != null){
                        $round_2 = $post->roundname2->round_name;
                    }else{
                        $round_2='';
                    }               
                    return $round_2;
                })
                ->addColumn('round_2_status', function ($post) {     
                    if($post->round_2 != null && $post->round_2_status != null){

                        $round_2_status = $post->round_2_status;
                        switch($round_2_status){
                            case(1):
                                $status = 'Scheduled';
                                break;
                            case(2):
                                $status = 'Selected';
                                break;
                            case(3):
                                $status = 'Rejected';
                                break;
                        }                    

                    }
                    else{
                        $status='';
                    }             
                    return $status;
                })
                ->addColumn('round_2_int', function ($post) {     
                    if($post->round_2 != null && $post->round_2_status != null){
                        $interviewer= JobScheduleModel::where('can_id','=',$post->can_id)->where('round','=','round_2')->select('interviewer_id')->first();  
                        if(!empty($interviewer)){
                            $int= $interviewer->employee->name; 
                        }
                        else{
                            $int='';
                        }
                             
                    }else{
                        $int='';
                    }
                    return $int;
                })                
                ->addColumn('round_3', function ($post) { 
                    if($post->round_3 != null){
                        $round_3 = $post->roundname3->round_name;
                    }else{
                        $round_3='';
                    }               
                    return $round_3;
                })

                ->addColumn('round_3_status', function ($post) {     
                    if($post->round_3 != null && $post->round_3_status != null){

                        $round_3_status = $post->round_3_status;
                        switch($round_3_status){
                            case(1):
                                $status = 'Scheduled';
                                break;
                            case(2):
                                $status = 'Selected';
                                break;
                            case(3):
                                $status = 'Rejected';
                                break;
                        }                    

                    }
                    else{
                        $status='';
                    }             
                    return $status;
                })
                ->addColumn('round_3_int', function ($post) {     
                    if($post->round_3 != null && $post->round_3_status != null){
                        $interviewer= JobScheduleModel::where('can_id','=',$post->can_id)->where('round','=','round_3')->select('interviewer_id')->first();  
                        if(!empty($interviewer)){
                            $int= $interviewer->employee->name; 
                        }
                        else{
                            $int='';
                        }
                             
                    }else{
                        $int='';
                    }
                    return $int;
                })
               
                ->addColumn('round_4', function ($post) { 
                    if($post->round_4 != null){
                        $round_4 = $post->roundname4->round_name;
                    }else{
                        $round_4='';
                    }               
                    return $round_4;
                })
                ->addColumn('round_4_status', function ($post) {     
                    if($post->round_4 != null && $post->round_4_status != null){

                        $round_4_status = $post->round_4_status;
                        switch($round_4_status){
                            case(1):
                                $status = 'Scheduled';
                                break;
                            case(2):
                                $status = 'Selected';
                                break;
                            case(3):
                                $status = 'Rejected';
                                break;
                        }                    

                    }
                    else{
                        $status='';
                    }             
                    return $status;
                })
                ->addColumn('round_4_int', function ($post) {     
                    if($post->round_4 != null && $post->round_4_status != null){
                        $interviewer= JobScheduleModel::where('can_id','=',$post->can_id)->where('round','=','round_4')->select('interviewer_id')->first();  
                        if(!empty($interviewer)){
                            $int= $interviewer->employee->name; 
                        }
                        else{
                            $int='';
                        }
                             
                    }else{
                        $int='';
                    }
                    return $int;
                })
                ->addColumn('round_5', function ($post) { 
                    if($post->round_5 != null){
                        $round_5 = $post->roundname5->round_name;
                    }else{
                        $round_5='';
                    }               
                    return $round_5;
                })
                ->addColumn('round_5_status', function ($post) {     
                    if($post->round_5 != null && $post->round_5_status != null){

                        $round_5_status = $post->round_5_status;
                        switch($round_5_status){
                            case(1):
                                $status = 'Scheduled';
                                break;
                            case(2):
                                $status = 'Selected';
                                break;
                            case(3):
                                $status = 'Rejected';
                                break;
                        }                    

                    }
                    else{
                        $status='';
                    }             
                    return $status;
                }) 
                ->addColumn('round_5_int', function ($post) {     
                    if($post->round_5 != null && $post->round_5_status != null){
                        $interviewer= JobScheduleModel::where('can_id','=',$post->can_id)->where('round','=','round_5')->select('interviewer_id')->first();  
                        if(!empty($interviewer)){
                            $int= $interviewer->employee->name; 
                        }
                        else{
                            $int='';
                        }
                             
                    }else{
                        $int='';
                    }
                    return $int;
                })
                ->addColumn('round_6', function ($post) { 
                    if($post->round_6 != null){                        
                        $round_6 = $post->roundname6->round_name;
                    }else{
                        $round_6='';
                    }               
                    return $round_6;
                })
                ->addColumn('round_6_status', function ($post) {     
                    if($post->round_6 != null && $post->round_6_status != null){

                        $round_6_status = $post->round_6_status;
                        switch($round_6_status){
                            case(1):
                                $status = 'Scheduled';
                                break;
                            case(2):
                                $status = 'Selected';
                                break;
                            case(3):
                                $status = 'Rejected';
                                break;
                        }                    

                    }
                    else{
                        $status='';
                    }             
                    return $status;
                })    
                ->addColumn('round_6_int', function ($post) {     
                    if($post->round_6 != null && $post->round_6_status != null){
                        $interviewer= JobScheduleModel::where('can_id','=',$post->can_id)->where('round','=','round_6')->select('interviewer_id')->first();  
                        if(!empty($interviewer)){
                            $int= $interviewer->employee->name; 
                        }
                        else{
                            $int='';
                        }
                             
                    }else{
                        $int='';
                    }
                    return $int;
                })       
                ->addColumn('round_7', function ($post) { 
                    if($post->round_7 != null){                        
                        $round_7 = $post->roundname7->round_name;
                    }else{
                        $round_7='';
                    }               
                    return $round_7;
                })
                ->addColumn('round_7_status', function ($post) {     
                    if($post->round_7 != null && $post->round_7_status != null){

                        $round_7_status = $post->round_7_status;
                        switch($round_7_status){
                            case(1):
                                $status = 'Scheduled';
                                break;
                            case(2):
                                $status = 'Selected';
                                break;
                            case(3):
                                $status = 'Rejected';
                                break;
                        }                    

                    }
                    else{
                        $status='';
                    }             
                    return $status;
                })
                ->addColumn('round_7_int', function ($post) {     
                    if($post->round_7 != null && $post->round_1_status != null){
                        $interviewer= JobScheduleModel::where('can_id','=',$post->can_id)->where('round','=','round_7')->select('interviewer_id')->first();  
                        if(!empty($interviewer)){
                            $int= $interviewer->employee->name; 
                        }
                        else{
                            $int='';
                        }
                             
                    }else{
                        $int='';
                    }
                    return $int;
                })   
                ->addColumn('offer_letter', function ($post) {     
                    $offer = JobOffer::where('can_id','=',$post->can_id)->select('offer_letter')->first();                    
                    if($offer != null){                        
                        $ol = $offer->offer_letter;
                    }else{
                        $ol='';
                    }
                    
                    return $ol;
                })   
                ->addColumn('offer_ack', function ($post) {     
                    $offer = JobOffer::where('can_id','=',$post->can_id)->select('offer_ack')->first();
                    if($offer!= null){
                        $ol_ack = $offer->offer_ack;
                    }else{
                        $ol_ack='';
                    }
                    
                    return $ol_ack;
                })   
                ->addColumn('offer_ack_date', function ($post) {     
                    $offer = JobOffer::where('can_id','=',$post->can_id)->select('offer_ack_date')->first();
                    if($offer != null){
                        $ol_ack_date = $offer->offer_ack_date;
                    }else{
                        $ol_ack_date='';
                    }
                    
                    return $ol_ack_date;
                })   
                ->addColumn('joining_date', function ($post) {     
                    $offer = JobOffer::where('can_id','=',$post->can_id)->select('joining_date')->first();
                    if($offer!= null){
                        $joining_date = $offer->joining_date;
                    }else{
                        $joining_date='';
                    }
                    
                    return $joining_date;
                })   
                ->addColumn('aor', function ($post) {     
                    $offer = JobOffer::where('can_id','=',$post->can_id)->select('appointment_order_received')->first();
                    if($offer!= null){
                        $aor = $offer->appointment_order_received	;
                    }else{
                        $aor='';
                    }
                    
                    return $aor;
                })   

                ->make(true);

            
        }
        return view('report.hr.candidate_tracker_report', compact('position', 'project', 'hr', 'interviewer', 'job'));
    }
}
