<?php

namespace App\Services;

use App\Models\attendance;
use App\Models\holidaymodel;
use App\Models\LeaveApplication;
use App\Models\TeamAllocations;
use App\Models\User;
use Carbon\Carbon;

/**
 * Class AttendanceService
 * @package App\Services
 */
class assignattendpm
{

    public function filteremp($request)
    {

        $now = Carbon::now();
        $id = $request->project;

        $primary1 = TeamAllocations::where('user_id', $id)
            ->where('is_primary_project', '=', 'yes')
            ->whereDate('end_date', '>=', $now)
            ->with('project')
            ->get('project_id');

        $secondary = TeamAllocations::where('user_id', $id)
            ->whereDate('start_date', '<=', $now)
            ->whereDate('end_date', '>=', $now)
            ->where('is_primary_project', '=', 'no')
            ->with('project')
            ->get('project_id');

        //$team_details = TeamAllocations::with('project')->get();
        //$today = Carbon::now()->format('d-m-Y');

        $emp_data = User::where('id', $id)->select('id', 'name', 'employee_code','last_name')->get()->first();


        $primary = $primary1->first();

        if (count($primary1) == 0) {

            $output = '                             

                <div class="alert alert-danger dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down">
                    <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                </svg>
                <p> Sorry , Primary Project not Assigned.</p>

            </div>';
        } elseif (count($secondary) != 0) {

            $i = -1;

            foreach ($secondary as $s) {


                ++$i;

                $output =  '<div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name">Employee Code</label>
                                    <input class="form-control" id="name" type="text"   required="required" value="' . $emp_data->employee_code . '" disabled="">
                                </div>                               

                                <div class="mb-3 col-md-6">
                                    <label for="name">Employee Name</label>
                                    
                                    <input class="form-control" id="name" type="text"   required="required" value="' . $emp_data->name . ' ' . $emp_data->last_name .'" disabled="">
                                    <input class="form-control" name="user_id" type="hidden"  required="required" value="' . $emp_data->id . '" readonly>
                                </div>
                                 
                            </div>
                           

                            <div class="row">
                           
               
                                 
                                <div class="mb-3 col-md-6">
                                    <label for="name">Primary Projects</label>

                                     
                                    <input class="form-control" name="primary_project[0][name]" type="text" value="' . $primary->project->project_name . '" required="required" readonly>


                                </div>



                                <div class="mb-3 col-md-6">
                                    <label for="name">Hours</label>
                                    <select class="form-select  " name="primary_project[0][hours]">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8" selected>8</option>
                                    </select>
                                </div>

                               

                                <div class=" col-md-6">
                                    <label for="name">Secondary Project(s)</label>


                                </div>

                                <div class=" col-md-6">



                                </div>
                                


                                <div class="mb-3 col-md-6">

                                    <label for="name"> </label>

                                    <input class="form-control" name="secondary[' . $i . '][project]" type="text" value="' . $s->project->project_name . '" required="required" readonly>


                                </div>


                                <div class="mb-3 col-md-6">
                                    <label for="name"> </label>
                                    <select class="form-select " name="secondary[' . $i . '][hours]">
                                        <option value="0" selected>0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                    </select>
                                </div>


                                


                             


                                </div>';
            }
        } else {


            $output =  '<div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name">Employee Code</label>
                                    <input class="form-control" id="name" type="text"   required="required" value="' . $emp_data->employee_code . '" disabled="">
                                </div>                               

                                <div class="mb-3 col-md-6">
                                    <label for="name">Employee Name</label>
                                    
                                    <input class="form-control" id="name" type="text"   required="required" value="' . $emp_data->name .' ' .$emp_data->last_name.'" disabled="">
                                    <input class="form-control" name="user_id" type="hidden"  required="required" value="' . $emp_data->id . '" readonly>
                                </div>
                                 
                            </div>
                           

                            <div class="row">
                           
               
                                 
                                <div class="mb-3 col-md-6">
                                    <label for="name">Primary Projects</label>

                                     
                                    <input class="form-control" name="primary_project[0][name]" type="text" value="' . $primary->project->project_name . '" required="required" readonly>


                                </div>



                                <div class="mb-3 col-md-6">
                                    <label for="name">Hours</label>
                                    <select class="form-select  " name="primary_project[0][hours]">
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8" selected>8</option>
                                    </select>
                                </div>

                               

                              

                                <div class=" col-md-6">



                                </div>
                                

 
                                <div class="mb-3 col-md-6">
                                <label for="name"> </label>
                                <input class="form-control" hidden name="secondary[1][project]" type="text" value=" " required="required" readonly>
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="name"> </label>
                                <select class="form-select " hidden name="secondary[1][hours]">
                                    <option value="0" selected>0</option>

                                </select>
                            </div>
                                

                                </div>';
        }



        return $output;
    }





    public function store($request)
    {
    
        $today = Carbon::now()->format('d-m-Y');

        $validate = $request->validate(
            [

                'attendance_date' => "required|date|before_or_equal:$today",

            ],

            $messages = [
                'attendance_date.before_or_equal' => 'Attendance for the future date is not allowed!',
            ]

        );


        $id = $request->user_id;
        $r_ad = Carbon::parse($request->attendance_date)->format('Y-m-d');

        //Validate Attendance for Same Date //
        $attendance_date = attendance::where('user_id', $id)->pluck('attendance_date')->toArray();
        $a_date = array_values($attendance_date);
        $result = in_array($r_ad, $a_date);

        //Validate Holidays//
        $holiday = holidaymodel::where('holidaystatus', '=', '1')->pluck('holidaydate')->toArray();
        $h_date = array_values($holiday);
        $holiday_result = in_array($r_ad, $h_date);

        
        if (!empty($request->secondary)) {

            $att_value = array_sum(array_column($request->secondary, 'hours'));
        } else {
            $att_value = 0;
        }
        //calculate total number of hours//

        $att_value1 = array_sum(array_column($request->primary_project, 'hours'));
        $att_value3 = $att_value + $att_value1;


        //Validate Leave//
        $leaves = LeaveApplication::where('user_id', $id)->get();

       
        
        foreach ($leaves as $leave) {

            $startDate = Carbon::parse($leave->startDate);
            $endDate = Carbon::parse($leave->endDate);
            $check = Carbon::parse($r_ad)->between($startDate, $endDate);


            if ($r_ad == $startDate || $r_ad == $endDate || $check == true) {
                
                if ($leave->leaveStatus == 0 || $leave->leaveStatus == 1) {
                   
                    if ($leave->noOfDayDeduct >= 1) {
                       
                        return back()->with('error2', 'Employee on Leave Today');
                    } elseif ($leave->noOfDayDeduct == 0.5 && $att_value3 > 4) {
                       
                        return back()->with('error2', 'Employee on Leave for half a day');
                        
                    } elseif ($leave->noOfDayDeduct == 0.5 && $att_value3 < 4) {


                        return back()->with('error2', 'Minimum 4 Hours Required.');
                    }
                }
            }
        }

        //Minimum hours Validation//

        if ($att_value3 < 4 || $att_value3 > 24) {

            return back()->with('error2', 'Minimum working hours 8');
        }

        if ($att_value3 > 4 && $att_value3 < 8) {

            return back()->with('error2', 'Please Apply leave before entering the attendance');
        }

        if ($holiday_result == true) {

            return back()->with('error2', 'Today is Holiday');
        } elseif ($result == true) {
            return back()->with('error2', 'Attendance Already Entered');
        } else {

            $sec = new attendance;
            $sec->user_id = $id;
            $sec->primary_project = request('primary_project');
            $sec->secondary_project = request('secondary');
            $sec->attendance_date = Carbon::parse($request->attendance_date)->format('Y-m-d');
            $sec->work_from = 'OD';

            if ($att_value3 >= 8) {

                $sec->day_count = 1;
            } elseif ($att_value3 = 4) {

                $sec->day_count = 0.5;
            } else {

                return back()->with('error2', 'Please Apply leave before entering the attendance for Half a day');
            }

            $sec->total_working_hours = $att_value3;

            $sec->save();
            return redirect()->route('attendance.index')->with('message', 'Attendance Marked');
        }
    }
}
