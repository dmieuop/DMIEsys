<?php

use App\Http\Controllers\DMIEsys\AdvisoryCommentController;
use App\Http\Controllers\DMIEsys\BaseCourseController;
use App\Http\Controllers\DMIEsys\CourseController;
use App\Http\Controllers\DMIEsys\CourseReportController;
use App\Http\Controllers\DMIEsys\DashboardController;
use App\Http\Controllers\DMIEsys\InventoryController;
use App\Http\Controllers\DMIEsys\LabController;
use App\Http\Controllers\DMIEsys\MachineController;
use App\Http\Controllers\DMIEsys\MaintenanceRecordController;
use App\Http\Controllers\DMIEsys\MaintenanceScheduleController;
use App\Http\Controllers\DMIEsys\StudentReportController;
use App\Http\Controllers\DMIEsys\ProfileController;
use App\Http\Controllers\DMIEsys\MarksController;
use App\Http\Controllers\DMIEsys\MessageController;
use App\Http\Controllers\DMIEsys\PermissionController;
use App\Http\Controllers\DMIEsys\SettingController;
use App\Http\Controllers\DMIEsys\StudentAdvisorController;
use App\Http\Controllers\DMIEsys\StudentController;
use App\Http\Controllers\DMIEsys\StudentsController;
use App\Http\Controllers\DMIEsys\PgStudentController;
use Illuminate\Support\Facades\Route;


Route::get('/email-verified-successfully', function () {
    return view('auth.email-verified');
});

Route::get('/changelog', function () {
    return view('dmiesys.general.changelog');
})->name('changelog');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/logs', [DashboardController::class, 'viewLogs'])->name('logs');
Route::get('/see-the-updates', [ProfileController::class, 'seeTheUpdates'])->name('new.updates');
Route::get('/inventory/restore/{id}', [InventoryController::class, 'restore'])->name('inventory.restore');
Route::get('/inventory/remove-photo/{id}', [InventoryController::class, 'deletePhoto'])->name('inventory.remove.photo');

Route::group(['prefix' => 'manage-courses'], function () {
    Route::get('/', [DashboardController::class, 'manageCourses'])->name('manage.courses');
    Route::resource('/base-course', BaseCourseController::class)->except('destroy');
    Route::resource('/course', CourseController::class)->except('destroy');
});

Route::group(['prefix' => 'manage-students'], function () {
    Route::get('/', [DashboardController::class, 'manageStudents'])->name('manage.students');
    Route::resource('/student', StudentController::class);
    Route::resource('/students', StudentsController::class);
});

Route::group(['prefix' => 'student-affairs'], function () {
    Route::get('/', [DashboardController::class, 'studentAffairs'])->name('student.affairs');
    Route::get('/students-advisor/create', [StudentAdvisorController::class, 'createBulk'])->name('students-advisor.create');
    Route::resource('/student-advisor', StudentAdvisorController::class);
    Route::resource('/meet-students', AdvisoryCommentController::class);
    Route::get('/meet-students/resolve/{id}', [AdvisoryCommentController::class, 'resolveNeedAttention'])->name('students-advisor.resolve');
});

Route::group(['prefix' => 'manage-marks'], function () {
    Route::get('/', [DashboardController::class, 'manageMarks'])->name('manage.marks');
    Route::resource('/marks', MarksController::class)->except('show', 'edit', 'update');
});

Route::group(['prefix' => 'student-attainment'], function () {
    Route::get('/', [DashboardController::class, 'studentAttainment'])->name('student.attainment');
    Route::resource('/student-report', StudentReportController::class)->only('index', 'show');
    Route::resource('/course-report', CourseReportController::class)->only('index', 'show');
});

Route::group(['prefix' => 'manage-labs'], function () {
    Route::get('/', [DashboardController::class, 'manageLabs'])->name('manage.labs');
    Route::resource('/labs', LabController::class)->except('destroy');
});

Route::group(['prefix' => 'manage-machines'], function () {
    Route::get('/', [DashboardController::class, 'manageMachines'])->name('manage.machines');
    Route::resource('/machines', MachineController::class);
    Route::resource('/maintenance-schedule', MaintenanceScheduleController::class);
    Route::resource('/maintenance-record', MaintenanceRecordController::class);
});

Route::group(['prefix' => 'pg-admin'], function () {
    Route::get('/', [DashboardController::class, 'pgAdmin'])->name('pg.admin');
    Route::resource('/pg-registrations', PgStudentController::class)->only('index');
});

Route::group(['prefix' => 'book-facility'], function () {
    Route::get('/', [DashboardController::class, 'bookFacility'])->name('book.facility');
    // Route::resource('/pg-registrations', PgStudentController::class)->only('index');
});


Route::resource('/messages', MessageController::class);
Route::resource('/user-profile', ProfileController::class);
Route::resource('/inventory', InventoryController::class)->except('edit');
Route::resource('/user-permissions', PermissionController::class);
Route::resource('/settings', SettingController::class)->only('index', 'update');
