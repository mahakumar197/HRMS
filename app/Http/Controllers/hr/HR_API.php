<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Agency;
use App\Models\InterviewRound;
use App\Models\InterviewTemplateModel;
use App\Models\Job;
use App\Models\JobInterview;
use App\Models\JobOffer;
use App\Models\JobPosition;
use App\Models\JobScheduleModel;
use App\Models\SkillSet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HR_API extends Controller
{
    public function getJob()
    {

        $job = Job::with(['user' => function ($user) {
            $user->select('id', 'name','last_name')->get();
        }])->get();


        return datatables($job)->addIndexColumn()
            ->addColumn('edit_job', function ($row) {

                if ($row->jd_upload != null) {
                    $action = '<button class="btn btn-primary btn-sm dropdown-toggle"  style="padding: 0rem 0.45rem; font-size:12px" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu" style=" background-color:#6dbff3">
                      <a  href="job/' . $row->id . '/edit " class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Job">Edit</a>
                      <a href=/jd/' . $row->jd_upload . '  target = "_blank" class="dropdown-item">Job Description</a>              
                      </div>                                
                    ';
                } else {
                    $action = '<button class="btn btn-primary dropdown-toggle" style="padding: 0rem 0.45rem; font-size:12px" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                <div class="dropdown-menu" style=" background-color:#6dbff3">
                  <a  href="job/' . $row->id . '/edit " class="dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Job">Edit</a>                          
                  </div>                                
                ';
                }


                return $action;
            })
            ->addColumn('add_candidate', function ($row) {
                if ($row->job_status != 1) {
                    $action = '<a  href="#" data-toggle="tooltip" data-placement="top" title="Trying to add candidate for cancelled job"> <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon">
                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                        <line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg></a>';
                } else {

                    $action = '<a  href="cancreate/' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Add Candidate"><svg xmlns="http://www.w3.org/2000/svg"  width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2">
                           </path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></a>
                           <line x1="3" y1="22" x2="21" y2="22"></line></svg></a>';
                }

                return $action;
            })

            ->addColumn('position', function ($row) {
                return $row->position->position_name;
            })
            ->addColumn('project', function ($row) {
                return $row->project->project_name;
            })

            ->addColumn('job_owner', function ($row) {
                $first_name = $row->user->name;
                $last_name = $row->user->last_name;
                $name = $first_name .' '.$last_name;
                return $name;
            })

            ->addColumn('count', function ($row) {

                /* $job_result = JobInterview::where('job_id', $row->id)->get();
                $selected_count = 0;
                foreach ($job_result as $jr) {

                    $result = [];
                    $result_status = [];
                    for ($i = 1; $i <= 10; $i++) {
                        $round = 'round_' . $i;
                        $round_status = 'round_' . $i . '_status';
                        if ($jr->$round != null) {
                            $result[] = $jr->$round;
                        }
                        if ($jr->$round_status != null && $jr->$round_status == 2) {
                            $result_status[] = $jr->$round_status;
                        }
                    }
                    if (count($result) == count($result_status)) {
                        ++$selected_count;
                    }
                }

                $remaining_count = $row->headcount - $selected_count;*/

                $remaining_count = JobOffer::where('job_id', $row->id)->where('appointment_order_received', '=', 'Yes')->count();

                if ($remaining_count != 0) {
                    $rem_count = $row->headcount - $remaining_count;

                    return $row->headcount . '/' . $rem_count;
                } else {
                    return $row->headcount . '/' . $row->headcount;
                }
            })

            ->editColumn('job_status', function ($inquiry) {

                $position = $inquiry->position->position_name;

                if ($inquiry->job_status == 0) return '<a href ="#" class="del_ btn btn-xs btn-danger btn-edit"  >Cancelled</a>';
                if ($inquiry->job_status == 1) return '<a href="#" data-toggle="tooltip" data-placement="top" title="Change Job Status" class="del_ btn btn-xs btn-success btn-edit"  id="' . $inquiry->id . '"  onclick="testFunction(' . $inquiry->id . ',' . $inquiry->job_status . '   )" >Active</a>';
                if ($inquiry->job_status == 2) return '<a href="#" data-toggle="tooltip" data-placement="top" title="Change Job Status" class="del_ btn btn-xs btn-warning btn-edit"  id="' . $inquiry->id . '"  onclick="testFunction(' . $inquiry->id . ',' . $inquiry->job_status . '   )" >On Hold</a>';
                if ($inquiry->job_status == 3) return '<a href="#" data-toggle="tooltip" data-placement="top" title="Change Job Status" class="del_ btn btn-xs btn-info btn-edit"  id="' . $inquiry->id . '"  onclick="testFunction(' . $inquiry->id . ',' . $inquiry->job_status . '   )" >Completed</a>';
            })

            ->addColumn('share', function ($row) {
                if ($row->job_status != 1) {
                    $share = '<a href="#" " data-toggle="tooltip" data-placement="top" title="Check Job Status">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon">
                    <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                    <line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg>
                </a>';
                } else {
                    $share = '<a href="#"    id="' . $row->id . '"  onclick="share(' . $row->emp_refer . ',' . $row->id . ')" data-toggle="tooltip" data-placement="top" title="Share Job">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                </a> <input type="hidden" id="name-' . $row->id . '"value="' . $row->position->position_name . '"> ';
                }

                return $share;
            })
            ->addColumn('job_int', function ($row) {

                $job_can = Candidate::where('job_id', $row->id)->select('id')->exists();

                if ($row->job_status == 1) {
                    if ($row->rounds == null) {
                        $job_int = '<a href="jobround/' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Create Interview Rounds">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-server">
                    <rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2">
                    </rect><line x1="6" y1="6" x2="6" y2="6"></line><line x1="6" y1="18" x2="6" y2="18"></line></svg>
                    </a>';
                    } elseif ($row->rounds != null && $row->emp_refer == 0 && $row->consultancy_refer == 0 && $job_can == false) {
                        $job_int = '<a href="job-interview/' . $row->id . '/edit" data-toggle="tooltip" data-placement="top" title="Edit Interview Rounds">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2">
                    <polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg>
                    </a>';
                    } else {
                        $job_int = '<a href="#" onclick="round(' . $row->id . ')" data-toggle="tooltip" data-placement="top" title="View Interview Rounds">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>                 
                    </a>';
                    }
                } else {
                    $job_int = '<a href="#" data-toggle="tooltip" data-placement="top" title="Check Job Status">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-octagon">
                     <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                     <line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12" y2="16"></line></svg></a>';
                }

                return $job_int;
            })
            ->addColumn('hr_int', function ($row) {

                $hr = '<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-filter">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>';

                return $hr;
            })
            ->addColumn('offer_process', function ($row) {
                if ($row->job_status == 0) {
                    $hr = "";
                } else {
                    $hr = '<a href="job-offer-process/' . $row->id . '" data-toggle="tooltip" data-placement="top" title="Offer Process">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="20" width="20" version="1.1" id="Layer_1" viewBox="0 0 392.563 392.563" xml:space="preserve">
                    <g>
                    <path style="fill:#56ACE0;" d="M350.608,370.754l-108.154-86.562l-39.305,31.354c-4.008,3.168-9.244,3.232-13.576,0l-39.434-31.354   L42.05,370.754H350.608z"/>
                    <polygon style="fill:#56ACE0;" points="183.626,34.981 208.967,34.981 196.297,24.896  "/>
                    <polygon style="fill:#56ACE0;" points="53.622,138.997 28.41,159.166 53.622,179.272  "/>
                    <polygon style="fill:#56ACE0;" points="339.036,179.272 364.183,159.166 339.036,138.997  "/>
                    <polygon style="fill:#56ACE0;" points="370.777,358.924 370.777,181.793 259.909,270.294  "/>
                    <polygon style="fill:#56ACE0;" points="21.88,181.793 21.88,358.924 132.684,270.294  "/>
                    </g>
                    <path style="fill:#FFC10D;" d="M134.107,97.882c0,6.012-4.848,10.925-10.925,10.925H75.408v19.782h22.82  c6.012,0,10.925,4.848,10.925,10.925c0,6.012-4.848,10.925-10.925,10.925h-22.82v46.352l39.952,31.806  c7.952-37.43,41.18-65.552,80.873-65.552s72.986,28.121,81.067,65.552l39.952-31.806V56.896H75.472v30.125h47.774  C129.194,87.021,134.107,91.87,134.107,97.882z M196.297,69.631c22.238,0,40.339,18.101,40.339,40.339s-18.101,40.339-40.339,40.339  s-40.339-18.101-40.339-40.339S174.058,69.631,196.297,69.631z"/>
                    <path style="fill:#FFFFFF;" d="M196.297,128.524c10.214,0,18.554-8.339,18.554-18.554s-8.339-18.554-18.554-18.554  c-10.214,0-18.554,8.339-18.554,18.554C177.743,120.249,186.082,128.524,196.297,128.524z"/>
                    <path style="fill:#194F82;" d="M196.297,150.375c22.238,0,40.339-18.101,40.339-40.339s-18.101-40.339-40.339-40.339  s-40.339,18.101-40.339,40.339C155.957,132.209,174.058,150.375,196.297,150.375z M196.297,91.417  c10.214,0,18.554,8.339,18.554,18.554s-8.339,18.554-18.554,18.554c-10.214,0-18.554-8.339-18.554-18.554  S186.082,91.417,196.297,91.417z"/>
                    <path style="fill:#FFFFFF;" d="M196.297,184.831c-29.931,0-54.691,21.657-59.863,50.101h119.79  C250.988,206.488,226.228,184.831,196.297,184.831z"/>
                    <polygon style="fill:#FFC10D;" points="241.937,256.718 150.656,256.718 196.297,293.179 "/>
                    <path style="fill:#194F82;" d="M392.563,158.973c0-3.556-1.875-6.465-4.073-8.339l-49.455-39.564V45.906  c0-6.012-4.848-10.925-10.925-10.925h-84.234L203.084,2.399c-4.008-3.168-9.632-3.168-13.576,0l-40.792,32.582h-84.17  c-6.012,0-10.925,4.848-10.925,10.925v65.164L4.103,150.698c-2.909,2.069-4.331,5.947-4.073,8.469v222.448  c0,6.012,4.848,10.925,10.925,10.925h370.683c6.012,0,10.925-4.849,10.925-10.925V159.166l0,0  C392.563,159.102,392.563,159.037,392.563,158.973z M339.036,138.997l25.212,20.17l-25.212,20.105V138.997z M196.297,24.896  l12.671,10.149h-25.341L196.297,24.896z M75.472,150.375h22.82c6.012,0,10.925-4.848,10.925-10.925s-4.848-10.925-10.925-10.925  h-22.82v-19.782h47.774c6.012,0,10.925-4.848,10.925-10.925c0-6.077-4.848-10.925-10.925-10.925H75.472V56.766H317.25v139.895  l-39.952,31.935c-8.016-37.43-41.244-65.552-81.002-65.552s-72.921,28.121-81.002,65.552l-39.952-31.806v-46.416H75.472z   M150.656,256.718h91.345l-45.705,36.461L150.656,256.718L150.656,256.718z M136.434,234.932  c5.172-28.444,29.996-50.101,59.863-50.101s54.691,21.657,59.863,50.101H136.434z M53.622,138.997v40.275L28.41,159.166  L53.622,138.997z M21.88,181.793l110.804,88.501L21.88,358.924V181.793z M42.05,370.754l108.089-86.497l39.305,31.354  c4.331,3.232,9.568,3.168,13.576,0l39.305-31.354l108.089,86.497H42.05z M370.777,358.924l-110.869-88.63l110.804-88.501v177.131  H370.777z"/>
                    </svg>
                    </a>';
                }

                return $hr;
            })

            ->rawColumns(['edit_job', 'add_candidate', 'job_status', 'share', 'job_int', 'hr_int', 'offer_process'])

            ->make(true);
    }

    public function getsharedata($id)
    {
        $job = Job::where('id', $id)->select('consultancy_refer', 'emp_refer', 'rounds', 'emp_show')->get();

        foreach ($job as $j) {
            if ($j->rounds != null) {
                if ($j->consultancy_refer != null) {
                    $a = $j->consultancy_refer;
                    $notshared = Agency::whereNotIn('id', $a)->select('id', 'consultancy_name', 'email')->get();
                    $shared = Agency::whereIn('id', $a)->select('id', 'consultancy_name', 'email')->get();
                } else {

                    $shared = [];
                    $notshared = Agency::select('id', 'consultancy_name', 'email')->get();
                }
            } else {
                return response()->json(['rounds' => 'Create Interview Rounds Before Job Sharing']);
            }
        }


        return response()->json(['job' => $job, 'shared' => $shared, 'notshared' => $notshared]);;
    }


    public function JobStatus(Request $request)
    {



        if ($request->job_status < 0 || $request->job_status > 3) {

            return redirect()->route('job.index')->with('error', 'Not A Valid Selection');
        }
        $job = Job::find($request->id);

        $job->job_status = $request->job_status;

        $job->update();

        return redirect()->route('job.index')->with('message', 'Job Status Changed Successfully');
    }

    //---------------------Job Position------------------//

    public function getjobposition()
    {


        $jobposition = JobPosition::orderBy('created_at', 'DESC')->get();

        return datatables($jobposition)->addIndexColumn()
            ->addColumn('action', function ($row) {

                $action = '<a  href=" job-position/' . $row->id . '/edit "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
            <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
            <line x1="3" y1="22" x2="21" y2="22"></line>
          </svg></a>';


                return $action;
            })
            ->rawColumns(['action'])
            ->editColumn('status', function ($inquiry) {
                if ($inquiry->status == 0) return 'InActive';
                if ($inquiry->status == 1) return 'Active';
            })
            ->make(true);
    }



    //------------------Agency Index--------------//

    public function getAgency()
    {

        $job = Agency::get();

        return datatables($job)->addIndexColumn()
            ->addColumn('action', function ($row) {

                $action = '<a  href="agency/' . $row->id . '/edit ">
                          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                          stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
                          <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
                          <line x1="3" y1="22" x2="21" y2="22"></line></svg></a>';

                return $action;
            })
            ->rawColumns(['action'])
            ->editColumn('status', function ($inquiry) {

                if ($inquiry->status == 0) return 'InActive';
                if ($inquiry->status == 1) return 'Active ';
            })

            ->make(true);
    }

    //------------------------Candidate Index----------------------//
    public function getCandidate()
    {
        if (Auth::user()->sub_role == 'hr' || Auth::user()->role == 'super_admin') {
            $candidate = Candidate::get();
        } elseif (Auth::user()->role == 'employee' || Auth::user()->role == 'project_manager') {
            $candidate = Candidate::where('referred_by', '=', Auth::user()->employee_code)->get();
        }

        return datatables($candidate)->addIndexColumn()
            ->addColumn('action', function ($row) {
                $can_interview = JobInterview::where('can_id', $row->id)->where('job_id', $row->job_id)->where('round_1_status', '!=', Null)->exists();
                $can_int_schedule = JobScheduleModel::where('can_id', '=', $row->id)->where('job_id', $row->job_id)->exists();

                if ($can_int_schedule == 'true' || $can_interview == 'true') {
                    $action = '<a  href="candidate/' . $row->id . ' " data-toggle="tooltip" data-placement="top" title="View Profile">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                    stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
                } else {

                    $action = '<a  href="candidate/' . $row->id . '/edit " data-toggle="tooltip" data-placement="top" title="Edit Profile">
                          <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                          stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
                          <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
                          <line x1="3" y1="22" x2="21" y2="22"></line></svg></a>';
                }
                return $action;
            })
            ->addColumn('can_int_edit', function ($row) {
                $offer = JobOffer::where('can_id', $row->id)->exists();

                if ($offer != 'true') {
                    $int_edit = '<a  href="candidate-int-round/' . $row->id . '  data-toggle="tooltip" data-placement="top" title="Edit Interview Rounds">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                    <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon></svg></a>';
                } else {
                    $offer = JobOffer::where('can_id', $row->id)->first();
                    if ($offer != '') {
                        if ($offer->document_verified == 'Yes' && $offer->offer_letter == null) {
                            $int_edit = '<h6 class="font-success fw-500">Document Verified</h6>';
                        } elseif ($offer->offer_letter == 'Yes' && $offer->offer_ack == null) {
                            $int_edit = '<h6 class="font-success fw-500">Offer Letter Sent</h6>';
                        } elseif ($offer->offer_ack == 'Yes' && $offer->appointment_order_received == null) {
                            $int_edit = '<h6 class="font-success fw-500">Offer Accepted</h6>';
                        } elseif ($offer->appointment_order_received == 'Yes') {
                            $int_edit = '<h6 class="font-success fw-500">Joined</h6>';
                        } else {
                            $int_edit = '<a  href="candidate-int-round/' . $row->id . '  data-toggle="tooltip" data-placement="top" title="Edit Interview Rounds">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                    <path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon></svg></a>';
                        }
                    }
                }



                return $int_edit;
            })

            ->rawColumns(['action', 'can_int_edit'])
            ->addColumn('job_code', function ($row) {
                return $row->job->job_code;
            })
            ->addColumn('referred_by', function ($row) {

                if ($row->outsourced_via != null) {
                    $referred_by = $row->outsourced_via;
                } elseif ($row->referred_by != null) {
                    $referred_by = User::where('employee_code', '=', $row->referred_by)->select('name', 'employee_code')->first();
                    $referred_by = "{$referred_by->name} - {$referred_by->employee_code}";
                } elseif ($row->consultancy_id != null) {
                    $referred_by = Agency::where('id', $row->consultancy_id)->select('consultancy_name')->first();
                    $referred_by = $referred_by->consultancy_name;
                }
                return $referred_by;
            })

            ->make(true);
    }

    //------------------------Employee Referral Index----------------------//


    public function getJob_empref()
    {

        $user_id = Auth::id();

        /*$j = Job::with('userpivot')->whereHas('userpivot', function ($q) use ($user_id) {
            $q->where('users_id', '=', $user_id)->where('ack', '=', '1');
        })->where('job_status', '=', '1')->get();*/

        $j = Job::where('job_status', '=', 1)->where('emp_show', '=', '1')->select('id', 'job_code', 'position_id', 'job_posted_date', 'headcount', 'experience_required', 'job_owner', 'importance', 'job_status')->get();


        return datatables($j)->addIndexColumn()
            ->addColumn('action', function ($row) {

                $action = '<a  href="cancreate/' . $row->id . '"><svg xmlns="http://www.w3.org/2000/svg"  width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2">
                      </path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></a>';

                return $action;
            })
            ->addColumn('view', function ($row) {
                $view = '<a href=" job-emp-profile/' . $row->id . ' "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg></a>';
                return $view;
            })

            ->addColumn('position', function ($row) {
                return $row->position->position_name;
            })
            ->addColumn('job_owner', function ($row) {
                return $row->user->name;
            })
            ->addColumn('remaining_count', function ($row) {

                /*$job_result = JobInterview::where('job_id', $row->id)->get();
                $selected_count = 0;
                foreach ($job_result as $jr) {

                    $result = [];
                    $result_status = [];
                    for ($i = 1; $i <= 10; $i++) {
                        $round = 'round_' . $i;
                        $round_status = 'round_' . $i . '_status';
                        if ($jr->$round != null) {
                            $result[] = $jr->$round;
                        }
                        if ($jr->$round_status != null && $jr->$round_status == 2) {
                            $result_status[] = $jr->$round_status;
                        }
                    }
                    if (count($result) == count($result_status)) {
                        ++$selected_count;
                    }
                }

                $remaining_count = $row->headcount - $selected_count;*/
                $remaining_count = JobOffer::where('job_id', $row->id)->where('appointment_order_received', '=', 'Yes')->count();

                return $remaining_count;
            })

            ->editColumn('job_status', function ($inquiry) {

                $position = $inquiry->position->position_name;

                if ($inquiry->job_status == 0) return 'Cancelled';
                if ($inquiry->job_status == 1) return 'Active';
                if ($inquiry->job_status == 2) return 'On Hold';
                if ($inquiry->job_status == 3) return 'Completed';
            })

            ->rawColumns(['action', 'job_status', 'view'])


            ->make(true);
    }

    /*----------------------------------------------------*/
    public function job_emp_profile($id)
    {
        $job = Job::with(['position' => function ($p) {
            $p->select('id', 'position_name');
        }, 'job_type' => function ($j) {
            $j->select('id', 'job_type');
        }, 'user' => function ($u) {
            $u->select('id', 'name');
        }])->where('id', $id)->select(
            'id',
            'position_id',
            'job_code',
            'candidate_type',
            'location',
            'job_description',
            'job_posted_date',
            'job_type_id',
            'headcount',
            'experience_required',
            'importance',
            'job_owner',
            'essential_skills',
            'desirable_skills'
        )->first();
        $job_essential_skill = $job->essential_skills;
        $job_desirable_skill = $job->desirable_skills;


        $essential_skills = SkillSet::whereIn('id', $job_essential_skill)->select('id', 'skillset')->get();

        if ($job_desirable_skill != null) {
            $desirable_skills = SkillSet::whereIn('id', $job_desirable_skill)->select('id', 'skillset')->get();
        } else {

            $desirable_skills = null;
        }

        return view('hr.referral.job-profile', compact('job', 'essential_skills', 'desirable_skills'));
    }



    public function getinterviewtemp()
    {

        $interview = InterviewTemplateModel::with('position')->get();

        return datatables($interview)->addIndexColumn()
            ->addColumn('position_name', function ($row) {
                return $row->position->position_name;
            })

            ->addColumn('action', function ($row) {

                $action = '<a  href="interview-template/' . $row->id . '/edit"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" 
                stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
                <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
                <line x1="3" y1="22" x2="21" y2="22"></line></svg></a>';
                return $action;
            })
            ->make(true);
    }

    public function getIntRounds(Request $request)
    {



        $job_int = Job::where('id', $request->id)->select('job_code', 'rounds')->first();


        $imp = implode(',', $job_int->rounds);


        $int_round = InterviewRound::whereIn('id', $job_int->rounds)->orderByRaw("FIELD(id, {$imp})")->get();
        // $int_round = InterviewRound::whereIn('id',$job_int->rounds)->orderByRaw(DB::raw("FIELD(id, $job_int)"))->get();



        return response()->json([$int_round, $job_int->job_code]);
    }
}
