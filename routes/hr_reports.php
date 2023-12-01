<?php

use App\Http\Controllers\reports\hr\CandidateTrackerReport;
use App\Http\Controllers\reports\hr\Daily_Project_Report;
use App\Http\Controllers\reports\hr\DailyHrReportController;
use App\Http\Controllers\reports\hr\OfferedJoinersReport;
use App\Http\Controllers\reports\hr\UNICEF_Report;
use Illuminate\Support\Facades\Route;




Route::group(['middleware' => 'hr_acl'], function () {
    Route::group(['middleware' => 'auth'], function () {

        Route::get('daily-hr-report', [DailyHrReportController::class, 'dailyHR_report']);
        Route::POST('daily-hr-report', [DailyHrReportController::class, 'dailyHR_report'])->name('daily-hr-report');
        Route::get('offered-joiners-report', [OfferedJoinersReport::class, 'offeredJoinersReport']);
        Route::POST('offered-joiners-report', [OfferedJoinersReport::class, 'offeredJoinersReport'])->name('offered-joiners-report');
        Route::get('unicef-report', [UNICEF_Report::class, 'unicefReport']);
        Route::POST('unicef-report', [UNICEF_Report::class, 'unicefReport'])->name('unicef-report');
        Route::get('daily-project-report', [Daily_Project_Report::class, 'dailyProjectReport'])->name('daily-project-report');        
        Route::get('daily-project-data', [Daily_Project_Report::class, 'dailyProjectData']);
        Route::POST('daily-project-data', [Daily_Project_Report::class, 'dailyProjectData'])->name('daily-project-data');
        Route::get('candidate-tracker-report', [CandidateTrackerReport::class, 'candidateTrackerReport']);
        Route::POST('candidate-tracker-report', [CandidateTrackerReport::class, 'candidateTrackerReport'])->name('candidate-tracker-report');
    });
});
