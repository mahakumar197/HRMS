<?php

use App\Http\Controllers\consultancy\Con_API;
use App\Http\Controllers\consultancy\ConCandidateController;
use App\Http\Controllers\consultancy\ConChangePasswordController;
use App\Http\Controllers\consultancy\ConChangePasswordFirstTimeController;
use App\Http\Controllers\consultancy\ConsultancyRefController;
use Illuminate\Support\Facades\Route;

Route::prefix('consultancy')->name('consultancy.')->group(function () {

    Route::middleware(['guest:consultancy', 'prevent-back-history'])->group(function () {
        Route::view('/', 'consultancy.welcome')->name('welcome');
    });

    Route::middleware(['auth:consultancy', 'prevent-back-history'])->group(function () {

        Route::middleware('con_password_change_at')->group(function () {
        Route::get('referral', [ConsultancyRefController::class, 'index'])->name('referral');

        Route::get('dashboard', [ConsultancyRefController::class, 'conHome'])->name('home');

        Route::resource('candidate', ConCandidateController::class);

        Route::get('/api/v2/job-conref', [Con_API::class, 'getJob_conref'])->name('api.getJob.conref');
        Route::get('get-candidate',[Con_API::class,'getCandidate'])->name('get.candidate');
       
        Route::get('consultancy-job-candidate/{id}',[Con_API::class,'jobCandidateSummary'])->name('con-job-candidate');
        
        Route::get('/cancreate/{id}', [ConCandidateController::class, 'cancreate']);

        Route::get('acknowledge/{id}', [ConsultancyRefController::class, 'ack']);
        Route::POST('acknowledge/{id}', [ConsultancyRefController::class, 'con_ack_reply']);

        Route::get('job-profile/{id}',[Con_API::class, 'job_data'])->name('job_data');
        Route::POST('job-profile/{id}',[Con_API::class, 'job_data']);
        
        Route::get('candidate-int-status',[Con_API::class,'candidate_int_status'])->name('candidate-int-status');
        Route::POST('candidate-int-status',[Con_API::class,'candidate_int_status']);

        Route::get('change-password', [ConChangePasswordController::class, 'index']);
        Route::post('change-password', [ConChangePasswordController::class, 'store'])->name('change.password');
        
        Route::get('data-hr-feedback/{id}', [Con_API::class, 'show_details']);

        });

        Route::get('password_change', [ConChangePasswordFirstTimeController::class, 'index']);
        Route::post('password_change', [ConChangePasswordFirstTimeController::class, 'store'])->name('First-Password-Change');
        
        

        
    });
});
