<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DesignationController;
use App\Http\Controllers\announcement;
use App\Http\Controllers\APIController;
use App\Http\Controllers\AssignAttendanceController;
use App\Http\Controllers\AssignLeaveController;
use App\Http\Controllers\attendance\register;
use App\Http\Controllers\AttendanceContoller;
use App\Http\Controllers\AttendanceReport;
use App\Http\Controllers\holiday;
use App\Http\Controllers\employeeController;
use App\Http\Controllers\projects;
use App\Http\Controllers\teamallocation;
use App\Http\Controllers\dashboard_superadmin;
use App\Http\Controllers\Auth\RedirectAuthenticatedUsersController;
use App\Http\Controllers\dashboard_employee;
use App\Http\Controllers\dashboard_projectmanager;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\LeaveApplicationController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\ManageLeaveApplicationController;
use App\Http\Controllers\Auth\ChangePasswordFirstTimeController;
use App\Http\Controllers\entitlement\CasualLeaveController;
use App\Http\Controllers\entitlement\PrivilegeLeaveController;
use App\Http\Controllers\entitlement\sickleaveController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\hr\CandidateController;
use App\Http\Controllers\hr\AgencyController;
use App\Http\Controllers\hr\EmpRefController;
use App\Http\Controllers\hr\HR_API;
use App\Http\Controllers\hr\Interview_API;
use App\Http\Controllers\hr\interview_feedback\HRInterviewFeedback;
use App\Http\Controllers\hr\InterviewTemplateController;
use App\Http\Controllers\hr\JobPosition;
use App\Http\Controllers\hr\JobController;
use App\Http\Controllers\hr\JobInterviewController;
use App\Http\Controllers\hr\SkillsetController;
use App\Http\Controllers\hr\InterviewRoundController;
use App\Http\Controllers\LeaveBalanceController;
use App\Http\Controllers\projectmanager\TeamAttendance;
use App\Http\Controllers\reports\AttendanceSummaryReport;
use App\Http\Controllers\reports\EmployeeActiveController;
use Illuminate\Routing\RouteGroup;
use App\Http\Controllers\reports\LeaveSummary;
use App\Http\Controllers\reports\TeamSummary;
use App\Http\Controllers\rr\projectmanagerRR;
use App\Http\Controllers\yearleave\leave_record;
use App\Http\Controllers\yearleave\yearleave_report;
use App\Models\feedback;
use App\Models\JobInterview;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\yearleave\audit_report;

/* newly Created */

use App\Http\Controllers\hr\JobScheduleController;
use App\Http\Controllers\hr\InterviewerController;
use App\Http\Controllers\hr\TechFeedbackController;
use App\Http\Controllers\hr\interview_feedback\CommonFeedbackController;
use App\Http\Controllers\hr\JobOfferController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'prevent-back-history'], function () {
    Route::get('/', function () {

        if (Auth::check()) {
            return view('welcome');
        } else {
            return view('auth/login');
        }
    });


    require __DIR__ . '/auth.php';
    require __DIR__ . '/consultancy.php';
    require __DIR__ . '/hr_reports.php';


    Route::group(['middleware' => 'password_change_at'], function () {

        Route::group(['middleware' => 'aclsuperadmin'], function () {
            Route::resource('designation', DesignationController::class)->middleware('auth');
            Route::resource('announcement', announcement::class)->middleware('auth');
            Route::resource('leavetype', LeaveTypeController::class)->middleware('auth');



            // Attendance Report
            Route::get('attendancereport/{year}/{month}', [AttendanceReport::class, 'index'])
                ->where('year', '20(19|22)')
                ->where('month', '(1[0-2]|0?[1-9])')
                ->name('report.attendancereport.index');

            //default redirection to current month and redirect if fail above route rules
            Route::get('attendances/{year?}/{month?}', function () {
                return redirect()->route('admin.attendances.index', ['year' => now()->year, 'month' => now()->format('m')]);
            })->name('report.attendancereport.redirect');

            //Reports//
            Route::resource('active-employee', EmployeeActiveController::class)->middleware('auth');
            Route::get('employee-join-report', [EmployeeActiveController::class, 'emp_join_report'])->middleware('auth');
            Route::get('employee-leaving-report', [EmployeeActiveController::class, 'emp_leaving_report'])->middleware('auth');
            Route::POST('employee-join-report', [EmployeeActiveController::class, 'emp_join_report'])->name('employee-join-report')->middleware('auth');
            Route::POST('employee-leaving-report', [EmployeeActiveController::class, 'emp_leaving_report'])->name('employee-leaving-report')->middleware('auth');
            //Leave Reports //
            Route::get('leave-report-all', [LeaveSummary::class, 'leavereportall'])->middleware('auth');
            Route::POST('leave-report-all', [LeaveSummary::class, 'leavereportall'])->middleware('auth')->name('leave-report-all');
            //Attend Summary Reports //
            Route::get('atten-report-all', [AttendanceSummaryReport::class, 'attendanceall'])->middleware('auth');
            Route::POST('atten-report-all', [AttendanceSummaryReport::class, 'attendanceall'])->middleware('auth')->name('atten-report-all');

            

            // attendance Register //
            Route::get('attendance-register', [register::class, 'index'])->name('attendance-register')->middleware('auth');
            Route::POST('attendance-register', [register::class, 'index'])->name('attendance-register')->middleware('auth');

            //Team Allocation Report//

            Route::get('team-allocate', [TeamSummary::class, 'teamall'])->middleware('auth');
            Route::POST('team-allocate', [TeamSummary::class, 'teamall'])->middleware('auth')->name('team-report-all');

            //API Controller Index Pages//


            Route::get('/api/v1/designations', [APIController::class, 'getDesignations'])->name('api.designations.index');
            Route::get('/api/v1/announcements', [APIController::class, 'getAnnouncements'])->name('api.announcements.index');


            // announcement image upload //

            Route::POST('uploadimg', [announcement::class, 'imgupload'])->name('uploadimg')->middleware('auth');

            // entitlement update screen //

            Route::resource('sickleave', sickleaveController::class)->middleware('auth');
            Route::resource('casualleave', CasualLeaveController::class)->middleware('auth');
            Route::resource('privilegeleave', PrivilegeLeaveController::class)->middleware('auth');
            Route::get('leavebalance', [LeaveBalanceController::class, 'index'])->name('leavebalance');
        });


        Route::group(['middleware' => 'aclprojectmanager'], function () {
            Route::get('project-wise-attendance',[AttendanceSummaryReport::class,'projectWiseAttendanceNotMarked'])->name('project-wise-attendance')->middleware('auth');
            Route::resource('assignleave', AssignLeaveController::class)->middleware('auth');
            Route::post('leavefetch', [AssignLeaveController::class, 'fetchEmployee'])->name('leavefetch');
            Route::get('getempleavebalance', [AssignLeaveController::class, 'getEmpLeaveBalance'])->name('getempleavebalance');
            Route::resource('manageleave', ManageLeaveApplicationController::class)->middleware('auth');
            Route::get('/approve/{id}', [ManageLeaveApplicationController::class, 'approve']);
            Route::POST('approve', [ManageLeaveApplicationController::class, 'approve'])->name('approve');
            Route::POST('reject', [ManageLeaveApplicationController::class, 'reject'])->name('reject');
            Route::get('/reject/{id}', [ManageLeaveApplicationController::class, 'reject']);
            Route::get('/change-status/{id}', [projects::class, 'changeStatus'])->middleware('auth');
            Route::get('leave-report-pm', [LeaveSummary::class, 'leavereportpm'])->middleware('auth');
            Route::POST('leave-report-pm', [LeaveSummary::class, 'leavereportall'])->middleware('auth')->name('leave-report-pm');
            Route::get('employee-details', [employeeController::class, 'index'])->name('employee-details')->middleware('auth');
            Route::get('employee-profile/{id}', [employeeController::class, 'show'])->middleware('auth');
            Route::get('atten-report-pm', [AttendanceSummaryReport::class, 'attendancepm'])->middleware('auth');
            Route::POST('atten-report-pm', [AttendanceSummaryReport::class, 'attendancepm'])->middleware('auth')->name('atten-report-pm');
            //RR - Reports//
            Route::get('pm-rr-report', [projectmanagerRR::class, 'index'])->name('pm-rr-report')->middleware('auth');
            Route::POST('pm-rr-report', [projectmanagerRR::class, 'index'])->name('pm-rr-report')->middleware('auth');

            //Year Leave - Reports//

            Route::get('year-leave-report', [yearleave_report::class, 'index'])->name('year-leave-report')->middleware('auth');
            Route::POST('year-leave-report', [yearleave_report::class, 'index'])->name('year-leave-report')->middleware('auth');

            //Year Leave Record- Reports//

            Route::get('year-leave-record', [leave_record::class, 'index'])->name('year-leave-record')->middleware('auth');
            Route::POST('year-leave-record', [leave_record::class, 'index'])->name('year-leave-record')->middleware('auth');

            //  Audit - Reports//

            Route::get('audit-report', [audit_report::class, 'index'])->name('audit-report')->middleware('auth');
            Route::POST('audit-report', [audit_report::class, 'index'])->name('audit-report')->middleware('auth');
            // Team Attendance //

            Route::get('teamattendance', [TeamAttendance::class, 'index'])->name('teamattendance')->middleware('auth');
            Route::POST('teamattendance', [TeamAttendance::class, 'pmsearch'])->middleware('auth');
            Route::POST('submitteam', [TeamAttendance::class, 'submitteam'])->middleware('auth');

            //API Controller Index Page//

            Route::get('/api/v1/manageleaves', [APIController::class, 'getManageLeaves'])->name('api.manageleaves.index');
            Route::get('/api/v1/myattendance', [APIController::class, 'myAttendances'])->name('api.myattendances.index');

            //Assign Attendance//
            Route::resource('assignattendance', AssignAttendanceController::class)->middleware('auth');
            Route::POST('assign_attendance_filter', [AssignAttendanceController::class, 'filter'])->middleware('auth')->name('assign_attendance_filter');
            Route::get('myattendance', [AttendanceContoller::class, 'myAttendance'])->name('myattendance')->middleware('auth');
        });



        //feedback api //
        Route::get('/api/v1/feedback', [APIController::class, 'fetchfeedback'])->name('api.feedback.index');
        Route::POST('feedback-show/{id}', [feedback::class, 'show'])->middleware('auth');
        Route::get('feedback-show/{id}', [feedback::class, 'show'])->middleware('auth');

        //Holiday API//
        Route::get('/api/v1/holidays', [APIController::class, 'getHolidays'])->name('api.holidays.index');
        Route::POST('/api/v1/holidays', [APIController::class, 'getHoliday_year'])->name('api.holidays.index');

        //common

        Route::resource('holiday', holiday::class)->middleware('auth');
        Route::POST('announcement-show/{id}', [announcement::class, 'show'])->middleware('auth');
        Route::get('announcement-show/{id}', [announcement::class, 'show'])->middleware('auth');
       
Route::post('/announcement/{announcement_id}/{user_id}',[announcement::class, 'likeAnnouncement'])->name('announcement.like');

        Route::post('/announcement/{announcement}/comment', [announcement::class, 'commentAnnouncement'])->name('announcement.comment');

        Route::get('/cancel/{id}', [LeaveApplicationController::class, 'cancel'])->middleware('auth');
        Route::POST('cancel', [LeaveApplicationController::class, 'cancel'])->name('cancel');
        Route::get('/approvedcancel/{id}', [ManageLeaveApplicationController::class, 'cancel'])->middleware('auth');
        Route::POST('approvedcancel', [ManageLeaveApplicationController::class, 'cancel'])->name('approvedcancel');
        Route::resource('attendance', AttendanceContoller::class)->middleware('auth');
        Route::resource('leave', LeaveApplicationController::class)->middleware('auth');
        Route::resource('feedback', FeedbackController::class)->middleware('auth');

        Route::get('change-password', [ChangePasswordController::class, 'index']);
        Route::post('change-password', [ChangePasswordController::class, 'store'])->name('change.password');
    });


    Route::group(['middleware' => 'auth'], function () {

        //Route::view('/dashboard', 'Dashboard')->name('dashboard');

        Route::get("/dashboard", [RedirectAuthenticatedUsersController::class, "home"])->name('dashboard');

        Route::group(['middleware' => 'checkRole:super_admin'], function () {
            Route::get('superadmin', [dashboard_superadmin::class, 'index'])->name('superadminDashboard');
        });
        Route::group(['middleware' => 'checkRole:project_manager'], function () {
            Route::get('projectmanager', [dashboard_projectmanager::class, 'index'])->name('projectmanagerDashboard');
        });
        Route::group(['middleware' => 'checkRole:employee'], function () {
            Route::get('employeedashboard', [dashboard_employee::class, 'index'])->name('employeeDashboard');
        });
    });
    Route::get('password_change', [ChangePasswordFirstTimeController::class, 'index'])->name('password.change');
    Route::post('password_change', [ChangePasswordFirstTimeController::class, 'store'])->name('password.change');


    //Leave - Reports//
    Route::group(['middleware' => 'auth'], function () {

        Route::get('leave-report-employee', [LeaveSummary::class, 'leavereportemp'])->middleware('auth');
        Route::POST('leave-report-employee', [LeaveSummary::class, 'leavereportall'])->middleware('auth')->name('leave-report-employee');

        Route::get('atten-report-emp', [AttendanceSummaryReport::class, 'attendanceemp'])->middleware('auth');
        Route::POST('atten-report-emp', [AttendanceSummaryReport::class, 'attendanceemp'])->middleware('auth')->name('atten-report-emp');


        Route::get('/api/v1/leaves', [APIController::class, 'getLeaves'])->name('api.leaves.index');
        Route::get('/api/v1/leaveshistory', [APIController::class, 'getLeavesHistory'])->name('api.leaveshistory.index');
        Route::get('/api/v1/attendances', [APIController::class, 'getAttendances'])->name('api.attendances.index');
        Route::post('/api/v1/projectmanagers', [APIController::class, 'fetchProjectManagers'])->name('api.projectmanagers.index');


        Route::post('empfetchAssAttend', [AssignAttendanceController::class, 'empfetchAssAttend'])->name('empfetchass');
        Route::post('empfetchAssAttendEmpCode', [AssignAttendanceController::class, 'empfetchAssAttendEmpCode'])->name('empfetchassempcode');


        //----------------------HR-PM-Superadmin-----------------------------//

        Route::group(['middleware' => 'pm_hr_superadmin_acl'], function () {
            Route::get('/api/v1/employees', [APIController::class, 'getEmployees'])->name('api.employees.index');
        });


        //----------------------HR Module-----------------------------//

        Route::group(['middleware' => 'hr_acl'], function () {
            Route::get('view-employee/{id}', [employeeController::class, 'show'])->middleware('auth');
            Route::resource('teamallocation', teamallocation::class)->middleware('auth');
            Route::get('getdesignation', [teamallocation::class, 'getDesignation'])->name('getdesignation');
            Route::get('project-timeline', [teamallocation::class, 'getProjectTimeline'])->name('project.timeline');
            Route::get('/api/v1/teamallocations', [APIController::class, 'getTeamAllocations'])->name('api.teamallocations.index');
            Route::resource('employee', employeeController::class)->middleware('auth');
            Route::post('datafetch', [teamallocation::class, 'fetchEmployee'])->name('datafetch');
            Route::post('projectfetch', [teamallocation::class, 'fetchProject'])->name('projectfetch');
            Route::resource('projects', projects::class)->middleware('auth');
            Route::get('/api/v1/activeprojects', [APIController::class, 'getActiveProjects'])->name('api.activeprojects.index');
            Route::get('/api/v1/inactiveprojects', [APIController::class, 'getInActiveProjects'])->name('api.inactiveprojects.index');
            Route::resource('job-position', JobPosition::class);
            Route::resource('skillset', SkillsetController::class);
            Route::resource('job', JobController::class);
            Route::resource('agency', AgencyController::class);
            Route::resource('interview-round', InterviewRoundController::class);
            Route::get('list/interview-round', [InterviewRoundController::class, 'getInterviewRounds'])->name('list.interview.round');
            Route::get('int-round', [HR_API::class, 'getIntRounds'])->name('int-round');
            Route::POST('int-round', [HR_API::class, 'getIntRounds']);
            Route::get('/api/v2/job', [HR_API::class, 'getJob'])->name('api.job.index');
            Route::get('/api/v2/agency', [HR_API::class, 'getAgency'])->name('api.agency.index');
            Route::POST('/api/v2/job_status', [HR_API::class, 'JobStatus']);
            Route::get('/api/v2/jobposition', [HR_API::class, 'getjobposition'])->name('api.jobposition.index');
            Route::POST('/api/v2/share/{id}', [HR_API::class, 'getsharedata'])->name('api.sharedata.index');
            Route::POST('sharemail', [JobController::class, 'sharemail'])->name('sharemail');


            Route::get('list/skillset', [SkillsetController::class, 'getSkillset'])->name('list.skillset');
            Route::get('list/hr-selected', [Interview_API::class, 'getHrSelected'])->name('list.hr-selected');
            Route::get('list/hr-rejected', [Interview_API::class, 'getHrRejected'])->name('list.hr-rejected');
            Route::get('hr-screening/{id}', [JobInterviewController::class, 'hr_screening'])->name('hr-screening');
            Route::get('list/hr-interview', [Interview_API::class, 'getHrNotInterviewed'])->name('list.hr-interview');

            Route::resource('job-interview', JobInterviewController::class);
            Route::view('hr-feedback-test', 'hr.interview.test')->name('hr-feedback-test');

            Route::view('con-share', 'mail.test-email-layout')->name('con-share');
            Route::view('can-con-int', 'consultancy.candidate.con-interview-status')->name('con-share');

            // interview pagination //

            Route::get('/job-candidate/{id}', [JobInterviewController::class, 'job_candidate'])->name('job-candidate');
            Route::get('get-more-candidate', [Interview_API::class, 'more_candidate'])->name('get-more-candidate');
            Route::get('get-can-details', [Interview_API::class, 'get_can_details'])->name('get-can-details');
            Route::resource('job-schedule', JobScheduleController::class);
            Route::get('job-re-schedule', [JobScheduleController::class, 're_schedule']);
            Route::get('get-feedback-details', [Interview_API::class, 'get_feedback_details'])->name('get-feedback-details');


            Route::get('/candidate-int-round/{id}', [JobInterviewController::class, 'canIntRound'])->name('candidate-interview-round');
            Route::POST('/candidate-int-round/{id}', [JobInterviewController::class, 'canIntRound']);
            Route::get('/hr-interview-feedback-form/{id}', [HRInterviewFeedback::class, 'hrInterview_feedback_form']);
            Route::get('/hr-submit-feedback/{id}', [HRInterviewFeedback::class, 'hr_submit_feedback']);
            Route::resource('hr-interview-feedback', HRInterviewFeedback::class);

            // interviewer  //

            Route::POST('candidate-int-round-save', [JobInterviewController::class, 'canIntRound_save'])->name('can-int-save');

            Route::get('data-hr-feedback/{id}', [HRInterviewFeedback::class, 'show_details']);

            Route::resource('interview-template', InterviewTemplateController::class);

            Route::get('/api/v2/interview', [HR_API::class, 'getinterviewtemp'])->name('api.interview.temp');
            Route::get('/jobround/{id}', [JobInterviewController::class, 'jobround']);
            Route::POST('jobround-save', [JobInterviewController::class, 'jobround_save'])->name('api.jobround.save');
            Route::get('/job-candidate/{id}', [JobInterviewController::class, 'job_candidate'])->name('job-candidate');


            // JOb Offer //

            Route::resource('job-offer', JobOfferController::class);
            Route::get('job-offer-process/{id}', [JobOfferController::class, 'get_shorlisted_index']);
            Route::get('shortlisted-candidate', [JobOfferController::class, 'shortlisted_candidate'])->name('shortlisted-candidate');
            Route::get('can-offer-details', [JobOfferController::class, 'can_offer_details'])->name('can-offer-details');

            //Candidate to Employee //           
            Route::get('candidate-to-emp/{id}', [employeeController::class, 'candidateToEmployee']);
            //  Route::POST('candidate-to-emp', [employeeController::class,'candidateToEmployee']);


        });

        Route::group(['middleware' => 'interviewer_acl'], function () {

            Route::get('get-feedcan-details', [Interview_API::class, 'get_feedcan_details'])->name('get-feedcan-details');

            Route::get('interviewer', [InterviewerController::class, 'index'])->name('interviewer');
            Route::get('interviewer-data', [InterviewerController::class, 'get_interviewer_data'])->name('interviewer-data');
            Route::view('tech-feedback', 'hr.interview_feedback.tech_feedback')->name('tech-feedback');
            //Interview Feedback//

            Route::get('/tech-interview-form/{id}', [TechFeedbackController::class, 'tech_feedback_form']);
            Route::resource('tech-interview-feedback', TechFeedbackController::class);
            Route::get('/common-interview-form/{id}', [CommonFeedbackController::class, 'common_feedback_form']);
            Route::resource('common-interview-feedback', CommonFeedbackController::class);

            // interview screen //

            // Route::get('list/can-interview',[Interview_API::class,'can_interview'])->name('list.can.interview');
            Route::POST('list/can-interview', [Interview_API::class, 'can_interview'])->name('list.can.interview');
        });

        Route::resource('candidate', CandidateController::class);
        Route::get('/api/v2/candidate', [HR_API::class, 'getCandidate'])->name('api.candidate.index');
        Route::get('/cancreate/{id}', [CandidateController::class, 'catcreate']);
        Route::get('emp-referral', [EmpRefController::class, 'index'])->name('emp-referral');

        Route::get('/api/v2/job-empref', [HR_API::class, 'getJob_empref'])->name('api.getJob.empref');
        Route::get('job-emp-profile/{id}', [HR_API::class, 'job_emp_profile'])->name('job_emp_profile');
        Route::POST('job-emp-profile/{id}', [HR_API::class, 'job_emp_profile']);

        Route::get('ref-job-details/{id}', [EmpRefController::class, 'ack']);
        Route::POST('ref-job-details/{id}', [EmpRefController::class, 'emp_ack_reply']);
    });
    
    Route::get('/scheduler', function() {
        Artisan::call('attendancenotmarkedemp:twelvepm');
    });
    
});
