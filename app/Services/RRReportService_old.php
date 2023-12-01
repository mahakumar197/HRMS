<?php

namespace App\Services;

use App\Student;

use App\Models\attendance;
use App\Models\LeaveApplication;
use App\Models\TeamAllocations;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;


/**
 * Class AttendanceService
 * @package App\Services
 */
class RRReportService
{
    /**
     * @return mixed
     */
    public function getAttendances($v_employee_id=null,$sdate=null,$flag=null,$v_employee_name=null,$month=null, $project_name=null)
    {



        $result1= attendance::where('user_id',$v_employee_id)->where('attendance_date',$sdate)->select('day_count','attendance_date','user_id','primary_project','secondary_project')->get()->toArray();




        if(count($result1)!=0){


     $collection = array();

     foreach($result1 as $key=>$value){

         $collection['day_count'] = $value['day_count'];
         $collection['user_id'] = $value['user_id'];
         $collection['attendance_date'] = $value['attendance_date'];

         if($project_name != null){
            foreach($value['primary_project'] as $p){

                if($p['name'] == $project_name){
    
                    $collection['project'] = $p['name'];
                    $collection['hours'] = $p['hours'];
    
                }
             }

         foreach($value['secondary_project'] as $e){

            if($e['project'] == $project_name){

                $collection['project'] = $e['project'];
                $collection['hours'] = $e['hours'];

            }
         }

        }else{

            $collection['project'] = "";
            $collection['hours'] ="0";
        }

   }
           $new = collect($collection);
           $result = $new->put('name',$v_employee_name);
           $result1 = $result->toArray();
}
          

		if(count($result1)==0){
			$result1= array();
            $result1=['attendance_date'=>$sdate,'day_count'=>0.0,'user_id'=>$v_employee_id,'name'=>$v_employee_name ,'project'=>"no",'hours'=>"0"];
            //$result1 = $result1->toArray();


			//$val[date] = $sdate;
			//$result[] =(object)$val;
		}

		// dd($result1);

		return $result1;

    }


    public function getleave($v_employee_id,$month){

        $leave_cl = LeaveApplication::whereMonth('startDate', '=', $month)->where('user_id',$v_employee_id)
        ->whereMonth('endDate', '=', $month)->where('leave_type_id','=','1')->where('leaveStatus','=','1')->select('noOfDayDeduct')->sum('noOfDayDeduct');



      //  $sum = array_sum($leave_cl);

          // dd($leave_cl);
        return $leave_cl;

    }


    public function getpl($v_employee_id,$month){

        $leave_pl = LeaveApplication::whereMonth('startDate', '=', $month)->where('user_id',$v_employee_id)
        ->whereMonth('endDate', '=', $month)->where('leave_type_id','=','2')->where('leaveStatus','=','1')->select('noOfDayDeduct')->sum('noOfDayDeduct');



      //  $sum = array_sum($leave_cl);

           //dd($leave_cl);
        return $leave_pl;

    }


    public function getrate($v_employee_id){

        $unit_rate = TeamAllocations::where('user_id',$v_employee_id)->where('is_primary_project','=','yes')
       ->where('status','=','1')->select('unit_rate')->value('unit_rate');






         //dd($unit_rate);

      //  $sum = array_sum($leave_cl);

         // dd($leave_cl);
        return $unit_rate;

    }





}
