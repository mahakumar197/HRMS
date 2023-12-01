<?php

namespace App\Http\Controllers;

use App\Models\AnnouncementModel;
use App\Models\attendance;
use App\Models\designation;
use App\Models\feedback;
use App\Models\holidaymodel;
use App\Models\LeaveApplication;
use App\Models\Projectmaster;
use App\Models\TeamAllocations;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;


class APIController extends Controller
{



  public function getHolidays()
  {

    $year = Carbon::now()->year;


    $holiday = holidaymodel::whereYear('holidaydate', '=', $year)->orderBy('holidayDate', 'ASC');

    return DataTables::eloquent($holiday)
      //return datatables($holiday)
      ->addIndexColumn()
      ->addColumn('action', function ($row) {
        if(Auth::user()->role == 'super_admin'){
        $action = '<a  href=" holiday/' . $row->id . '/edit "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" 
                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
                  <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
                  <line x1="3" y1="22" x2="21" y2="22"></line>
                  </svg></a>';
        }else{
          $action='';
        }


        return $action;
      })
      ->rawColumns(['action'])

      ->editColumn('holidaystatus', function ($inquiry) {
        if ($inquiry->holidaystatus == 0) return 'InActive';
        if ($inquiry->holidaystatus == 1) return 'Active';
      })

      ->filterColumn('holidaystatus', function ($query, $keyword) {
        $query->whereRaw("IF( holidaystatus = 1, 'Active', 'InActive') like ?", ["%{$keyword}%"]);
      })

      ->make(true);
  }

  public function getHoliday_year(Request $request)
  {

    $holiday = holidaymodel::whereYear('holidaydate', '=', $request->year)->orderBy('holidayDate', 'ASC');

    return DataTables::eloquent($holiday)
      //return datatables($holiday)
      ->addIndexColumn()
      ->addColumn('action', function ($row) {
        if(Auth::user()->role == 'super_admin'){
        $action = '<a  href=" holiday/' . $row->id . '/edit "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" 
                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
                  <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
                  <line x1="3" y1="22" x2="21" y2="22"></line>
                  </svg></a>';
        }else{
          $action='';
        }
        return $action;
      })
      ->rawColumns(['action'])

      ->editColumn('holidaystatus', function ($inquiry) {
        if ($inquiry->holidaystatus == 0) return 'InActive';
        if ($inquiry->holidaystatus == 1) return 'Active';
      })

      ->filterColumn('holidaystatus', function ($query, $keyword) {
        $query->whereRaw("IF( holidaystatus = 1, 'Active', 'InActive') like ?", ["%{$keyword}%"]);
      })

      ->make(true);
  }

  public function getDesignations()
  {

    $designation = designation::get();

    return datatables($designation)->addIndexColumn()
      ->addColumn('action', function ($row) {

        $action = '<a  href=" designation/' . $row->id . '/edit "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
            <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
            <line x1="3" y1="22" x2="21" y2="22"></line>
          </svg></a>';


        return $action;
      })
      ->rawColumns(['action'])->make(true);
  }

  public function getEmployees()
  {

    if (Auth::user()->role == 'project_manager') {

      $employee = User::with('designation')->with('team', 'team.project.userteam')->whereHas('team', function ($t) {
        $t->whereHas('project', function ($p) {
          $p->where('user_id', Auth::user()->id);
        })->where('is_primary_project', '=', 'yes');
      })->where('employee_status', '=', '1')->get(['id', 'name','last_name','exit_date', 'joining_date', 'designation_id', 'phone_number', 'emergency_contact', 'employee_status', 'employee_code', 'image_path', 'role']);
    }


    if (Auth::user()->role == 'super_admin' || Auth::user()->sub_role == 'hr') {

      $employee = User::with('designation')->with('team', 'team.project.userteam')->get(['id', 'name','last_name', 'joining_date','exit_date', 'designation_id', 'phone_number', 'emergency_contact', 'employee_status', 'employee_code', 'image_path', 'role']);
    }


    return datatables($employee)->addIndexColumn()
      ->addColumn('action', function ($row) {

        if (Auth::user()->role == 'super_admin') {
          $action = '<a  href=" employee/' . $row->id . '/edit "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
           <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
           <line x1="3" y1="22" x2="21" y2="22"></line>
         </svg></a>  <a  href=" employee-profile/' . $row->id . ' "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file">
         <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg></a>';
        }
        if (Auth::user()->sub_role == 'hr') {
          $action = '<a  href=" employee/' . $row->id . '/edit "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
           <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
           <line x1="3" y1="22" x2="21" y2="22"></line>
         </svg></a>  <a  href=" view-employee/' . $row->id . ' "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file">
         <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg></a>';
        }
        if (Auth::user()->role == 'project_manager') {
          $action = '<a  href=" employee-profile/' . $row->id . ' "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file">
         <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg></a>';
        }


        return $action;
      })
      ->rawColumns(['action'])

      ->addColumn('name', function ($row) {
        $first_name = $row->name;
        $last_name = $row->last_name;        
        $name = $first_name .' '. $last_name;
        return $name;
      })
      ->addColumn('dor',function($row){
        if(Carbon::parse($row->exit_date)->gt(Carbon::now())){
          $dor = '-';
        }
        else{
          $dor = $row->exit_date;
        }
        return $dor;
      })
      ->addColumn('designation', function ($row) {
        return $row->designation->designation;
      })
      ->addColumn('reporting_to', function ($row) {
        $today = Carbon::now();
        $project = $row->team->where('is_primary_project', '=', 'yes')->first();


        if ($project != null) {
          $first_name = $row->team->where('is_primary_project', '=', 'yes')->first()->project->userteam->name;
          $last_name = $row->team->where('is_primary_project', '=', 'yes')->first()->project->userteam->last_name;        
          $reporting_to = $first_name .' '. $last_name;

         
        } else {

          $reporting_to = '-';
        }

        return $reporting_to;
      })
      ->editColumn('role', function ($user) {
        if ($user->role == 'super_admin') return 'Super Admin';
        if ($user->role == 'project_manager') return 'Project Manager';
        if ($user->role == 'employee') return 'Employee';
      })
      ->editColumn('employee_status', function ($inquiry) {
        if ($inquiry->employee_status == 0) return 'InActive';
        if ($inquiry->employee_status == 1) return 'Active';
      })

      ->make(true);
  }


  public function getActiveProjects()
  {
    $today = Carbon::today();
    $project = Projectmaster::with(['userteam' => function ($user) {
      $user->select('id', 'name','last_name')->get();
    }])->where('end_date', '>=', $today);

    return DataTables::eloquent($project)
      //return datatables($project)
      ->addIndexColumn()
      ->addColumn('action', function ($row) {

        $action = '<a  href=" projects/' . $row->id . '/edit "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
            <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
            <line x1="3" y1="22" x2="21" y2="22"></line>
          </svg></a>';

        return $action;
      })
      ->rawColumns(['action'])

      ->addColumn('name', function ($row) {
        $first_name = $row->userteam->name;
        $last_name = $row->userteam->last_name;        
        $name = $first_name .' '. $last_name;
        return $name;
      })

      ->editColumn('status', function ($inquiry) {
        if ($inquiry->status == 0) return 'In Active';
        if ($inquiry->status == 1) return 'Active';
      })
      ->filterColumn('status', function ($query, $keyword) {
        $query->whereRaw("IF( status = 1, 'Active', 'InActive') like ?", ["%{$keyword}%"]);
      })
      ->make(true);
  }

  public function getInActiveProjects()
  {
    $today = Carbon::today();
    $project = Projectmaster::with(['userteam' => function ($user) {
      $user->select('id', 'name','last_name')->get();
    }])->where('end_date', '<', $today);

    return DataTables::eloquent($project)
      //return datatables($project)
      ->addIndexColumn()
      ->addColumn('action', function ($row) {

        $action = '<a  href=" projects/' . $row->id . '/edit "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
            <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
            <line x1="3" y1="22" x2="21" y2="22"></line>
          </svg></a>';

        return $action;
      })

      ->addColumn('name', function ($row) {
        $first_name = $row->userteam->name;
        $last_name = $row->userteam->last_name;        
        $name = $first_name .' '. $last_name;
        return $name;
      })


      ->addColumn('status', function ($row) {

        if ($row->status == 0) return 'InActive';
        if ($row->status == 1) return 'Active';
      })
      ->filterColumn('status', function ($query, $keyword) {
        $query->whereRaw("IF( status = 1, 'Active', 'InActive') like ?", ["%{$keyword}%"]);
      })

      ->addColumn('status_action', function ($inquiry) {
        $active = '<a href="change-status/' . $inquiry->id . '/" onclick="return confirm("Are you Sure?")" class="btn btn-xs btn-success"><i class="fa fa-thumbs-o-up"></i> Make Active</a>';
        $inactive = '<a href="change-status/' . $inquiry->id . '/" onclick="return confirm("Are you Sure?")" class="btn btn-xs btn-danger"><i class="fa fa-thumbs-o-down"></i> Make InActive</a>';
        if ($inquiry->status == 0) return $active;
        if ($inquiry->status == 1) return $inactive;
      })
      ->rawColumns(['action', 'status_action'])

      ->make(true);
  }

  public function getTeamAllocations()
  {

    $team = TeamAllocations::with(['user' => function ($user) {
      $user->select('id', 'name','last_name', 'employee_code', 'designation_id', 'joining_date')->with('designation')->orderBy('joining_date', 'ASC')->get();
    }, 'project' => function ($project) {
      $project->select('id', 'project_name', 'user_id')->get();
    }])->whereHas('user', function ($u) {
      $u->where('employee_status', '=', '1');
    })->get();

    return datatables($team)->addIndexColumn()
      ->addColumn('action', function ($row) {

        $action = '<a  href=" teamallocation/' . $row->id . '/edit "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
            <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
            <line x1="3" y1="22" x2="21" y2="22"></line>
          </svg></a>';


        return $action;
      })
      ->rawColumns(['action'])
      ->addColumn('employee_code', function ($row) {
        return $row->user->employee_code;
      })
      ->addColumn('employee_name', function ($row) {
        $first_name = $row->user->name;
        $last_name = $row->user->last_name;        
        $name = $first_name .' '. $last_name;
        return $name;
      })
      ->addColumn('employee_join', function ($row) {
        return $row->user->joining_date;
      })
      ->addColumn('designation', function ($row) {
        return $row->user->designation->designation;
      })
      ->addColumn('project', function ($row) {
        return $row->project->project_name;
      })
      ->addColumn('project_manager', function ($row) {
        $first_name = $row->project->userteam->name;
        $last_name = $row->project->userteam->last_name;        
        $name = $first_name .' '. $last_name;
        return $name;
      })
      ->make(true);
  }


  public function getAnnouncements()
  {

    $announcement = AnnouncementModel::orderBy('created_at', 'DESC');

    return DataTables::eloquent($announcement)
      //return datatables($announcement)
      ->addIndexColumn()
      ->addColumn('action', function ($row) {

        $action = '<a  href=" announcement/' . $row->id . '/edit "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
            <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
            <line x1="3" y1="22" x2="21" y2="22"></line>
          </svg></a>';

        return $action;
      })
      ->rawColumns(['action'])
      ->editColumn('description', function ($announcement) {
        return strip_tags(htmlspecialchars_decode($announcement->description));
      })
      ->editColumn('status', function ($inquiry) {
        if ($inquiry->status == 0) return 'InActive';
        if ($inquiry->status == 1) return 'Active';
      })
      ->filterColumn('status', function ($query, $keyword) {
        $query->whereRaw("IF( status = 1, 'Active', 'InActive') like ?", ["%{$keyword}%"]);
      })

      ->make(true);
  }

  public function getManageLeaves()
  {

    $now = Carbon::today();
    $current_month = $now->month;
    $id = Auth::user()->id;

    if (Auth::user()->role == 'super_admin') {
      $leave_details = LeaveApplication::with('user.designation', 'leaveType')->orderBy('leaveStatus', 'ASC')->orderBy('startDate', 'DESC')->get();
    } else {
      $leave_details = LeaveApplication::with('user.designation', 'leaveType')->whereHas('user', function ($user) use ($id) {
        $user->where('employee_status', '=', '1')->whereHas('team', function ($team) use ($id) {
          $team->where('is_primary_project', '=', 'yes')->whereHas('project', function ($project) use ($id) {
            $project->where('user_id', $id);
          });
        });
      })->orderBy('leaveStatus', 'ASC')->orderBy('startDate', 'DESC')->get();
    }

    //return DataTables::eloquent($leave_details)
    return datatables($leave_details)
      ->addIndexColumn()
      ->addColumn('action', function ($row) {

        $action = '<a href="" class="del_ btn btn-xs btn-success btn-edit"  id="' . $row->id . '" onclick="testFunction(event, ' . $row->id . ')" >Approve</a> <a href="" class="del_ btn btn-xs btn-danger btn-edit"  id="' . $row->id . '" onclick="testFunction_reject(event, ' . $row->id . ')" >Reject</a>';


        if ($row->leaveStatus == 0) return $action;
      })

      ->addColumn('cancelLeave', function ($row) use ($now) {

        $action = '<a href="" class="del_ "  id="' . $row->id . '" onclick="testFunction_cancel(event, ' . $row->id . ')" >
        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
        stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-octagon">
        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
        </polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a>';

        if (Carbon::parse($row->startDate) >= $now && $row->leaveStatus == 1) return $action;
      })

      ->addColumn('editLeave', function ($row) {

        $action = '<a  href=" leave/' . $row->id . '/edit "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
        <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
        <line x1="3" y1="22" x2="21" y2="22"></line>
      </svg></a>';

        return $action;
      })



      ->rawColumns(['action', 'cancelLeave', 'editLeave'])


      ->addColumn('employee_name', function ($row) {
        $first_name = $row->user->name;
        $last_name = $row->user->last_name;        
        $name = $first_name .' '. $last_name;
        return $name;        
      })
      ->editColumn('leave_type', function ($inquiry) {
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


  //Leave Summary//

  public function getLeaves()
  {

    $now = Carbon::today()->format('Y-m-d');


    $leave_details =  LeaveApplication::where('user_id', Auth::id())->where('startDate', '>=', $now)->orderBy('startDate', 'DESC')->orderBy('endDate', 'DESC')->get();

    return datatables($leave_details)->addIndexColumn()
      ->addColumn('cancelLeave', function ($row) use ($now) {

        $action = '<a href="" class="del_ "  id="' . $row->id . '" onclick="testFunction_cancel(event, ' . $row->id . ')" ><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-octagon">
        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
        </polygon><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></a>';

        if ($row->leaveStatus == 0) return $action;
      })
      ->addColumn('action', function ($row) {

        $action = '<a  href=" leave/' . $row->id . '/edit "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
        <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
        <line x1="3" y1="22" x2="21" y2="22"></line>
      </svg></a>';

        if ($row->leaveStatus == 0) return $action;
      })

      ->rawColumns(['action', 'cancelLeave'])


      ->editColumn('leave_type', function ($inquiry) {
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



  public function getLeavesHistory()
  {


    $now = Carbon::today()->format('Y-m-d');


    $leave_details =  LeaveApplication::where('user_id', Auth::id())->where('startDate', '<', $now)->orderBy('startDate', 'DESC')->orderBy('endDate', 'DESC')->get();

    return datatables($leave_details)->addIndexColumn()

      ->addColumn('action', function ($row) {

        $action = '<a  href=" leave/' . $row->id . '/edit "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
        <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
        <line x1="3" y1="22" x2="21" y2="22"></line>
      </svg></a>';
        if ($row->leaveStatus == 0 && $row->startDate >= Carbon::today()) return $action;
      })

      ->rawColumns(['action'])

      ->addColumn('employee_name', function ($row) {
        return $row->user->name;
      })
      ->editColumn('leave_type', function ($inquiry) {
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


  //Leave Summary ends//

  public function getAttendances()
  {
    $id = Auth::id();
    $today = Carbon::today();
    $current_month = $today->month;
    $current_year = $today->year;

    if (Auth::user()->role == 'project_manager') {

      $emp_attend = attendance::with(['finduser' => function ($user) {
        $user->select('id', 'employee_code', 'name','last_name')->get();
      }])->whereHas('finduser', function ($user) use ($id) {
        $user->where('employee_status', '=', '1')->whereHas('team', function ($team) use ($id) {
          $team->where('is_primary_project', '=', 'yes')->whereHas('project', function ($project) use ($id) {
            $project->where('user_id', $id);
          });
        });
      })->whereMonth('attendance_date', $current_month)->whereYear('attendance_date',$current_year)->get();
    }

    if (Auth::user()->role == 'super_admin') {

      $emp_attend = attendance::whereMonth('attendance_date', $current_month)->whereYear('attendance_date',$current_year)->get();
    }

    if (Auth::user()->role == 'employee') {

      $emp_attend = attendance::where('user_id', $id)->whereMonth('attendance_date', $current_month)->whereYear('attendance_date',$current_year)->get();
    }

    return datatables($emp_attend)

      ->addIndexColumn()
      ->addColumn('action', function ($row) {

        $action = '<a  href=" attendance/' . $row->id . '/edit "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
            <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
            <line x1="3" y1="22" x2="21" y2="22"></line>
          </svg></a>';


        return $action;
      })


      ->addColumn('employee_code', function ($row) {
        return $row->finduser->employee_code;
      })
      ->addColumn('employee_name', function ($row) {
        $first_name = $row->finduser->name;
        $last_name = $row->finduser->last_name;        
        $name = $first_name .' '. $last_name;
        return $name;
      })
      ->addColumn('primary_project', function ($primary) {
        $projects = [];
        foreach ($primary['primary_project'] as $e) {
          $projects = $e["name"];
        }
        return [$projects];
      })
      ->addColumn('primary_project_hours', function ($primary_hours) {
        $hours = [];
        foreach ($primary_hours['primary_project'] as $e) {
          $hours = $e["hours"];
        }
        return [$hours];
      })
      ->addColumn('secondary_project', function ($primary) {
        $projects = [];
        foreach ($primary['secondary_project'] as $e) {
          $projects[] = $e["project"];
        }
        return $projects;
      })
      ->addColumn('secondary_project_hours', function ($primary_hours) {
        $hours = [];
        foreach ($primary_hours['secondary_project'] as $e) {
          $hours = $e["hours"];
        }
        return [$hours];
      })
      ->rawColumns(['action', 'primary_project', 'primary_project_hours', 'secondary_project', 'secondary_project_hours'])

      ->make(true);
  }

  public function myAttendances()
  {
    $id = Auth::id();
    $today = Carbon::today();
    $current_month = $today->month;
    $current_year = $today->year;

    $emp_attend = attendance::where('user_id', $id)->whereMonth('attendance_date', $current_month)->whereYear('attendance_date',$current_year)->get();

    return datatables($emp_attend)

      ->addIndexColumn()
      ->addColumn('action', function ($row) {

        $action = '<a  href=" attendance/' . $row->id . '/edit "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
            <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
            <line x1="3" y1="22" x2="21" y2="22"></line>
          </svg></a>';

        return $action;
      })

      ->addColumn('employee_code', function ($row) {
        return $row->finduser->employee_code;
      })
      ->addColumn('employee_name', function ($row) {
        $first_name = $row->finduser->name;
        $last_name = $row->finduser->last_name;        
        $name = $first_name .' '. $last_name;
        return $name;
      })
      ->addColumn('primary_project', function ($primary) {
        $projects = [];
        foreach ($primary['primary_project'] as $e) {
          $projects = $e["name"];
        }
        return [$projects];
      })
      ->addColumn('primary_project_hours', function ($primary_hours) {
        $hours = [];
        foreach ($primary_hours['primary_project'] as $e) {
          $hours = $e["hours"];
        }
        return [$hours];
      })
      ->addColumn('secondary_project', function ($primary) {
        $projects = [];
        foreach ($primary['secondary_project'] as $e) {
          $projects[] = $e["project"];
        }
        return $projects;
      })
      ->addColumn('secondary_project_hours', function ($primary_hours) {
        $hours = [];
        foreach ($primary_hours['secondary_project'] as $e) {
          $hours[] = $e["hours"];
        }

        return [$hours];
      })
      ->rawColumns(['action', 'primary_project', 'primary_project_hours', 'secondary_project', 'secondary_project_hours'])

      ->make(true);
  }

  ///used in employee master create and edit//

  function fetchProjectManagers(Request $request)
  {

    $search = $request->search;

    if ($search == '') {
      $employees = User::orderby('name', 'asc')->with('designation')->where('role', '!=', 'employee')->select('name', 'employee_code')->limit(5)->get();
    } else {
      $employees = User::orderby('name', 'asc')->with('designation')->where('role', '!=', 'employee')->select('name', 'employee_code')->where('name', 'like', '%' . $search . '%')->limit(5)->get();
    }

    $response = array();
    foreach ($employees as $employee) {

      $response[] = array("label" => $employee->name, "label2" => $employee->employee_code);
    }

    return response()->json($response);
  }

  // feedback //

  function fetchfeedback()
  {

    if (Auth::user()->role == 'super_admin') {
      $feedback = feedback::orderBy('feedback_date', 'DESC');
    } else {
      $feedback = feedback::where('email', Auth::user()->email)->orderBy('feedback_date', 'DESC');
    }

    return DataTables::eloquent($feedback)      
      ->addIndexColumn()
      ->addColumn('action', function ($row) {
        $action = '<a  href=" feedback/' . $row->id . ' "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file">
      <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg></a>';
        return $action;
      })
      ->rawColumns(['action'])

      ->make(true);
  }
}
