<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\designation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables as DataTablesDataTables;

use Yajra\DataTables\Facades\DataTables;

class EmployeeActiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $today = now()->format('Y-m-d');

        $date = Carbon::parse($request->emp_date)->format('Y-m-d');


        if (request()->ajax()) {


            //$input=  array();
            // parse_str($request['data'], $input);            


            if ($date != '' && $date <= $today) {               

                $data = User::with('designation')->select('name', 'last_name','employee_code', 'employee_status', 'designation_id', 'joining_date')

                    ->where('joining_date', '<=', $date)
                    ->where('exit_date', '>', $date);

                return DataTables::eloquent($data)
                    ->addColumn('users', function (User $post) {
                        return $post->designation->designation;
                    })
                    ->addColumn('name',function($row){
                        $first_name = $row->name;
                        $last_name = $row->last_name;
                        $name = $first_name . ' ' . $last_name;
                        return $name;
                    })

                    
                    ->editColumn('employee_status', function ($inquiry) {
                        if ($inquiry->employee_status == 1) return 'Active';
                        if ($inquiry->employee_status == 0) return 'InActive';
                    })
                    ->filterColumn('employee_status', function($query, $keyword) { 
                        $query->whereRaw("IF(employee_status = 1, 'Active', 'InActive') like ?", ["%{$keyword}%"]); 
                    })
                    ->make(true);
            } else {

                return datatables()->make(true);
               
            }

            //  return datatables()->of($data)->addColumn('designation', function ($post) {
            //        return $post->designation->name;
            //   })->make(true);

            //$data = User::with('designation');

        }

        // $designation=User::with('designation')->get('designation_id');

        return view('report.employee-active.index');



       


    }


    public function emp_join_report(Request $request)
    {
       


        if (request()->ajax()) {




            if ($request->emp_from_date != '' && $request->emp_to_date != '') {
                
                $from_date = Carbon::parse($request->emp_from_date);
                $to_date = Carbon::parse($request->emp_to_date);


                $data = User::with('designation')->select('name','last_name' , 'employee_code', 'employee_status', 'designation_id', 'joining_date')
                    ->whereDate('joining_date', '>=', $from_date)
                    ->whereDate('joining_date', '<=', $to_date);


                // ->whereBetween('joining_date',[$request->emp_from_date, $request->emp_to_date])->get();                                                                                                    

              
                return DataTables::eloquent($data)
                    ->addColumn('users', function (User $post) {
                        return $post->designation->designation;
                    })
                    ->addColumn('name',function($row){
                        $first_name = $row->name;
                        $last_name = $row->last_name;
                        $name = $first_name . ' ' . $last_name;
                        return $name;
                    })
                    
                    ->editColumn('employee_status', function ($inquiry) {
                        if ($inquiry->employee_status == 1) return 'Active';
                        if ($inquiry->employee_status == 0) return 'Inactive';
                    })
                    ->filterColumn('employee_status', function ($query, $keyword) {
                        $query->whereRaw("IF( employee_status = 1, 'Active', 'InActive') like ?", ["%{$keyword}%"]);
                      })
                    ->make(true);
            } else {

                return datatables()->make(true);
            }
        }



        return view('report.employee-active.employee-join-report');
    }


    public function emp_leaving_report(Request $request)
    {
       
        if (request()->ajax()) {


            if ($request->emp_from_date != '' && $request->emp_to_date != '') {

                $from_date = Carbon::parse($request->emp_from_date);
                $to_date = Carbon::parse($request->emp_to_date);

                $data = User::with('designation')->select('name','last_name', 'employee_code', 'employee_status', 'designation_id', 'joining_date', 'exit_date')
                    ->whereDate('exit_date', '>=', $from_date)
                    ->whereDate('exit_date', '<=', $to_date);


                // ->whereBetween('joining_date',[$request->emp_from_date, $request->emp_to_date])->get();                                                                                                    

                return DataTables::eloquent($data)
                    ->addColumn('users', function (User $post) {
                        return $post->designation->designation;
                    })
                    
                    ->addColumn('name',function($row){
                        $first_name = $row->name;
                        $last_name = $row->last_name;
                        $name = $first_name . ' ' . $last_name;
                        return $name;
                    })
                    
                    ->editColumn('employee_status', function ($inquiry) {
                        if ($inquiry->employee_status == 1) return 'Active';
                        if ($inquiry->employee_status == 0) return 'Inactive';
                    })
                    ->filterColumn('employee_status', function ($query, $keyword) {
                        $query->whereRaw("IF( employee_status = 1, 'Active', 'InActive') like ?", ["%{$keyword}%"]);
                      })
                    ->make(true);
            } else {

                return datatables()->make(true);
            }
        }



        return view('report.employee-active.employee-leaving-report');
    }
}
