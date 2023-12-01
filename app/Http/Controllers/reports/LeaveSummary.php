<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\LeaveApplication;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;


class LeaveSummary extends Controller
{
    public function leavereportall(Request $request)
    {
        if (request()->ajax()) {


            if ($request->leave_from_date != '' && $request->leave_to_date != '') {

                $from_date = Carbon::parse($request->leave_from_date);
                $to_date = Carbon::parse($request->leave_to_date);

                $data = LeaveApplication::whereDate('startDate', '>=', $from_date)
                    ->whereDate('endDate', '<=', $to_date)
                    ->select(['id', 'startDate', 'endDate', 'user_id', 'leave_type_id', 'leaveStatus', 'noOfDayDeduct'])->get();

                return datatables($data)

                    ->addIndexColumn()

                    ->addColumn('emp_name', function ($post) {
                        $first_name = $post->user->name;
                        $last_name = $post->user->last_name;
                        $name = $first_name . ' ' . $last_name;
                        return $name;
                    })
                    ->addColumn('emp_code', function ($post) {
                        return $post->user->employee_code;
                    })
                    ->addColumn('designation', function ($post) {
                        return $post->user->designation->designation;
                    })
                    ->addColumn('leave_type', function ($inquiry) {
                        if ($inquiry->leave_type_id == 1) return 'CL';
                        if ($inquiry->leave_type_id == 2) return 'PL';
                        if ($inquiry->leave_type_id == 3) return 'SL';
                        if ($inquiry->leave_type_id == 5) return 'LOP';
                    })

                    ->editColumn('leaveStatus', function ($inquiry) {
                        if ($inquiry->leaveStatus == 0) return 'Pending';
                        if ($inquiry->leaveStatus == 1) return 'Approved';
                        if ($inquiry->leaveStatus == 2) return 'Rejected';
                        if ($inquiry->leaveStatus == 3) return 'Cancelled';
                    })

                    ->make(true);
            }
        }
        return view('report.leave-summary.superadmin-leave');
    }



    //-------------Employee Leave Summary Report ------------ //


    public function leavereportemp(Request $request)
    {

        $id = Auth::user()->id;


        if (request()->ajax()) {


            if ($request->leave_from_date != '' && $request->leave_to_date != '') {


                $from_date = Carbon::parse($request->leave_from_date);
                $to_date = Carbon::parse($request->leave_to_date);

                $data = LeaveApplication::where('user_id', '=', $id)->whereDate('startDate', '>=', $from_date)
                    ->whereDate('endDate', '<=', $to_date)
                    ->orderBy('startDate', 'DESC')->get();

                return datatables($data)->addIndexColumn()


                    ->addColumn('emp_name', function ($post) {
                        $first_name = $post->user->name;
                        $last_name = $post->user->last_name;
                        $name = $first_name . ' ' . $last_name;
                        return $name;
                    })
                    ->addColumn('emp_code', function ($post) {
                        return $post->user->employee_code;
                    })
                    ->addColumn('designation', function ($post) {
                        return $post->user->designation->designation;
                    })
                    ->addColumn('leave_type', function ($inquiry) {
                        if ($inquiry->leave_type_id == 1) return 'CL';
                        if ($inquiry->leave_type_id == 2) return 'PL';
                        if ($inquiry->leave_type_id == 3) return 'SL';
                        if ($inquiry->leave_type_id == 5) return 'LOP';
                    })

                    ->editColumn('leaveStatus', function ($inquiry) {
                        if ($inquiry->leaveStatus == 0) return 'Pending';
                        if ($inquiry->leaveStatus == 1) return 'Approved';
                        if ($inquiry->leaveStatus == 2) return 'Rejected';
                        if ($inquiry->leaveStatus == 3) return 'Cancelled';
                    })

                    ->make(true);
            }
        }


        return view('report.leave-summary.employee-leave');
    }



    // ------------------Project Manager Leave Summary Report-------------------//



    public function leavereportpm(Request $request)
    {

        if (request()->ajax()) {


            $id = Auth::user()->id;

            if ($request->leave_from_date != '' && $request->leave_to_date != '') {


                $from_date = Carbon::parse($request->leave_from_date);
                $to_date = Carbon::parse($request->leave_to_date);

                $data = LeaveApplication::whereHas('user', function ($user) use ($id) {
                    $user->where('employee_status', '=', '1')->whereHas('team', function ($team) use ($id) {
                        $team->where('is_primary_project', '=', 'yes')->whereHas('project', function ($project) use ($id) {
                            $project->where('user_id', $id);
                        });
                    });
                })->whereDate('startDate', '>=', $from_date)
                    ->whereDate('endDate', '<=', $to_date)->orderBy('startDate', 'DESC')->get();


                return datatables($data)->addIndexColumn()


                    ->addColumn('emp_name', function ($post) {
                        $first_name = $post->user->name;
                        $last_name = $post->user->last_name;
                        $name = $first_name . ' ' . $last_name;
                        return $name;
                    })
                    ->addColumn('emp_code', function ($post) {
                        return $post->user->employee_code;
                    })
                    ->addColumn('designation', function ($post) {
                        return $post->user->designation->designation;
                    })
                    ->addColumn('leave_type', function ($inquiry) {
                        if ($inquiry->leave_type_id == 1) return 'CL';
                        if ($inquiry->leave_type_id == 2) return 'PL';
                        if ($inquiry->leave_type_id == 3) return 'SL';
                        if ($inquiry->leave_type_id == 5) return 'LOP';
                    })

                    ->editColumn('leaveStatus', function ($inquiry) {
                        if ($inquiry->leaveStatus == 0) return 'Pending';
                        if ($inquiry->leaveStatus == 1) return 'Approved';
                        if ($inquiry->leaveStatus == 2) return 'Rejected';
                        if ($inquiry->leaveStatus == 3) return 'Cancelled';
                    })

                    ->make(true);
            }
        }


        return view('report.leave-summary.pm-leave');
    }
}
