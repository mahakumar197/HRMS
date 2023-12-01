<?php

namespace App\Http\Controllers\reports\hr;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobOffer;
use App\Models\JobScheduleModel;
use Carbon\Carbon;

class Daily_Project_Report extends Controller
{
    public function dailyProjectReport()
    {
        return view('report.hr.daily_project_report');
    }
    public function dailyProjectData()
    {

        $jobs = Job::select('id','headcount')->get();

        $completed_jobs = [];

        foreach ($jobs as $j){            
            $joined = JobOffer::where('job_id', $j->id)->where('appointment_order_received', '=', 'Yes')->count();

            if($joined == $j->headcount){
                $completed_jobs[] = $j->id;
            }
        }
    
        $job = Job::whereNotIn('id',$completed_jobs)->where('job_status','=',1)->get();



        return datatables($job)->addIndexColumn()

            ->addColumn('project', function ($row) {

                $project = $row->project->project_name;
                return $project;
            })
            ->addColumn('position', function ($row) {

                $position = $row->position->position_name;
                return $position;
            })
            ->addColumn('offered', function ($row) {

                $offered = JobOffer::where('job_id', '=', $row->id)->where('offer_letter', '=', 'Yes')->count();
                return $offered;
            })
            ->addColumn('joined', function ($row) {

                $offered = JobOffer::where('job_id', '=', $row->id)->where('appointment_order_received', '=', 'Yes')->count();
                return $offered;
            })
            ->addColumn('remaining', function ($row) {
              
                $joined_count = JobOffer::where('job_id', $row->id)->where('appointment_order_received', '=', 'Yes')->count();
                $remaining_count = $row->headcount - $joined_count;
                return $remaining_count;
            })
            ->addColumn('interview_today', function ($row) {
              
                $interview_today = JobScheduleModel::where('job_id', $row->id)->where('schedule_date', '=', Carbon::today())->count();
                
                return $interview_today;
            })

           



            ->make(true);
    }
}
