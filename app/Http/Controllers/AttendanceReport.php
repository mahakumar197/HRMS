<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\AttendanceReportService;
use Illuminate\Support\Facades\Route;




class AttendanceReport extends Controller
{

    private $AttendanceReportService;

    /**
     * AttendanceController constructor.
     * @param AttendanceReportService $AttendanceReportService
     */
    public function __construct(AttendanceReportService $AttendanceReportService)
    {
        $this->AttendanceReportService = $AttendanceReportService;
    }

    /**
     * @return Factory|RedirectResponse|View
     */
    public function index()
    {


        $selectedYear  = Route::current()->parameters()['year'];
        $selectedMonth = Route::current()->parameters()['month'];



        //don't let to navigate to future attendances
        if ($this->AttendanceReportService->isProvidedMonthGreaterThanCurrentMonth($selectedYear, $selectedMonth)) {
            return redirect()->route('dashboard');
        }

        $daysInMonth     = $this->AttendanceReportService->daysInMonth($selectedYear, $selectedMonth);

        $students        = User::all();
        $attendances     = $this->AttendanceReportService->getAttendances();
        $getLeave         = $this->AttendanceReportService->getLeave();
        $getLeavetype     = $this->AttendanceReportService->getLeavetype();

          

        $paginationLinks = $this->AttendanceReportService->getAttendancePaginationLinks($selectedYear, $selectedMonth);
      
        return view('report.attendancereport.index', compact(
            'attendances', 'students', 'paginationLinks', 'daysInMonth', 'selectedYear', 'selectedMonth','getLeave','getLeavetype'
        ));
    }


}
