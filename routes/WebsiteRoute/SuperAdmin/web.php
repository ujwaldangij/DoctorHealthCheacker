<?php

use App\Http\Controllers\WebsiteController\SuperAdmin\DashboardController;
use App\Http\Controllers\WebsiteController\SuperAdmin\doctor;
use App\Http\Controllers\WebsiteController\SuperAdmin\LoginRegisterController;
use App\Http\Controllers\WebsiteController\SuperAdmin\schedule;
use Illuminate\Support\Facades\Route;

Route::controller(LoginRegisterController::class)->middleware('RedirectUser')->group(function (){
    Route::get("/register","index2")->name('register');
    Route::post("/postRegister","postRegister")->name('postRegister');
    Route::get("/login","index1")->name('login');
    Route::post("/postLogin","postLogin")->name('postLogin')->middleware("throttle:rate_control");
});

Route::controller(DashboardController::class)->middleware(['CheckUser'])->group(function (){
    Route::get("/dashboard","index")->name('dashboard');
    Route::get("/markedAsRead/{id}","markedAsRead")->name('markedAsRead');
    Route::get("/logout","logout")->name('logout');
});

Route::controller(doctor::class)->middleware(['CheckUser'])->group(function (){
    Route::get("/choose_doctor","index")->name('choose_doctor');
    Route::get("/choose_doctor/{id}","choose")->name('choose_id');
    Route::post("/choose_doctor/{id}","postchooseid")->name('postchooseid');
    Route::get("/choose_id_delete/{id}",[doctor::class,'choose_id_delete'])->name('choose_id_delete');
    Route::get("/choose_id_edit/{id}",[doctor::class,'choose_id_edit'])->name('choose_id_edit');
    Route::post("/choose_id_edit_post/{id}",[doctor::class,'choose_id_edit_post'])->name('choose_id_edit_post');
});

Route::controller(schedule::class)->middleware(['CheckUser'])->group(function (){
    Route::get("/schedule","schedule")->name('schedule');
    Route::get("/add_person/{id}","add_person")->name('add_person');
    Route::get("/add_person_regect/{id}","add_person_regect")->name('add_person_regect');
    Route::post("/add_person_regect/{id}","add_person_regect_post")->name('add_person_regect_post');
    Route::post("/add_person/{id}","add_person_post")->name('add_person_post');
    Route::get("/upload_report/{id}","upload_report")->name('upload_report');
    Route::post("/upload_report_post/{id}","upload_report_post")->name('upload_report_post');
    Route::get("/schedule_id_delete_post/{id}","schedule_id_delete_post")->name('schedule_id_delete_post');
    Route::get("/schedule_id_edit/{id}","schedule_id_edit")->name('schedule_id_edit');
    Route::post("/schedule_id_edit_post/{id}","schedule_id_edit_post")->name('schedule_id_edit_post');
    Route::get("/medicine_reminder","medicine_reminder")->name('medicine_reminder');
    Route::get("/medicine_reminder/{id}","medicine_reminder_get")->name('medicine_reminder_get');
    Route::get("/track","track");
    Route::get("/track/{id}","track_id")->name('track_id');
});


Route::get("/send",[DashboardController::class,"show"]);
Route::get("/read/{id}",[DashboardController::class,"update"])->name('read');

Route::fallback(function (){
    return view("WebsitePages.SuperAdmin.404");
})

?>
