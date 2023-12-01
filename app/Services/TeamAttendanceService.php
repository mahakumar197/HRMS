<?php

namespace App\Services;

use App\Models\attendance;
use App\Models\holidaymodel;
use App\Models\LeaveApplication;
use App\Models\TeamAllocations;
use Carbon\Carbon;

class TeamAttendanceService
{


    public function submitattend($request = Null)
    {


        foreach ($request->user as $eid) {

            $leave_user_id = array();
            //-  $entered_user_id = 0;
            
            $id = $eid;
            $r_ad = Carbon::parse($request->attend_date)->format('Y-m-d');

            //Validate Attendance for Same Date //
            $attendance_date = attendance::where('user_id', $id)->pluck('attendance_date')->toArray();

            $a_date = array_values($attendance_date);
            $result = in_array($r_ad, $a_date);


            //Validate Holidays//
            $holiday = holidaymodel::where('holidaystatus', '=', '1')->pluck('holidaydate')->toArray();
            $h_date = array_values($holiday);
            $holiday_result = in_array($r_ad, $h_date);

            //Validate Leave//
            $leaves = LeaveApplication::where('user_id', $id)->get();

            foreach ($leaves as $leave) {

                $startDate = Carbon::parse($leave->startDate);
                $endDate = Carbon::parse($leave->endDate);
                $check = Carbon::parse($r_ad)->between($startDate, $endDate);

                if ($r_ad == $startDate || $r_ad == $endDate || $check == true) {
                    if ($leave->leaveStatus == 0 || $leave->leaveStatus == 1) {

                        $leave_user_id[] = $eid;
                        //$leave_user_id2[] = $eid;
                    }
                }
            }



            if ($holiday_result == true) {

                return back()->with('error2', 'Today is Holiday');
            } elseif ($result == true) { // Attendance Already Entered


                // $entered_user_id[] = $eid;

            } elseif (empty($leave_user_id)) {


                $attend = new attendance;


                $secondary_project = TeamAllocations::with('project')->where('user_id', $eid)->where('is_primary_project', '=', 'no')->where('status', '=', '1')->select('project_id')->get();

               
                // $count = count($secondary_project);


                $y = 0;

                $temp = array();

                if($secondary_project->isEmpty()){

                    $temp[$y]  = array(
                        'project' => '-',
                        'hours'   => "-"
                    );

                }else{


                foreach ($secondary_project as $s) {


                    $temp[$y]  = array(
                        'project' => $s->project->project_name,
                        'hours'   => "0"
                    );

                    $y++;
                }

            }
                 
                $attend->user_id = $eid;
                $attend->primary_project = request('primary_project');
                $attend->secondary_project = $temp;
                $attend->attendance_date = carbon::parse($request->attend_date);
                $attend->work_from = 'OD';
                $attend->total_working_hours = 8;
                $attend->day_count = 1;


                $attend->save();
            }
        }
    }
}
