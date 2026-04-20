<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\HomeController;


// 1. The New Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Public Admission Routes
Route::get('/apply', [StudentController::class, 'showApplicationForm'])->name('apply');
Route::post('/apply', [StudentController::class, 'submitApplication'])->name('apply.submit');
Route::post('/apply/status', [StudentController::class, 'checkStatus'])->name('apply.status'); // NEW

// Authentication Routes (Login, Logout, Passwords)
Auth::routes();

// Universal Home Route (The Traffic Cop)
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // User Management (Added Edit and Update)
    Route::get('/users', [AdminController::class, 'userIndex'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [AdminController::class, 'edit'])->name('users.edit'); // NEW
    Route::put('/users/{id}', [AdminController::class, 'update'])->name('users.update'); // NEW
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');

    // Section Management
    Route::resource('sections', \App\Http\Controllers\SectionController::class);
    Route::post('/sections/{id}/enroll', [\App\Http\Controllers\SectionController::class, 'enrollStudent'])->name('sections.enroll');
    Route::post('/sections/{id}/schedule', [\App\Http\Controllers\SectionController::class, 'addSchedule'])->name('sections.schedule');
    Route::delete('/sections/{section}/unenroll/{user}', [\App\Http\Controllers\SectionController::class, 'unenrollStudent'])->name('sections.unenroll');
    
    // Admission Management
    Route::get('/applications/{id}', [AdminController::class, 'showApplication'])->name('admin.applications.show'); // NEW
    Route::post('/applications/{id}/approve', [AdminController::class, 'approveApplication'])->name('admin.applications.approve');

    // Subject Management
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
    Route::get('/subjects/{id}/edit', [SubjectController::class, 'edit'])->name('subjects.edit'); // NEW
    Route::put('/subjects/{id}', [SubjectController::class, 'update'])->name('subjects.update'); // NEW
    Route::delete('/subjects/{id}', [SubjectController::class, 'destroy'])->name('subjects.destroy'); // NEW

// Schedule
Route::delete('/schedules/{id}', [SectionController::class, 'destroySchedule'])->name('schedules.destroy');
Route::get('/schedules/{id}/edit', [SectionController::class, 'editSchedule'])->name('schedules.edit');
Route::put('/schedules/{id}', [SectionController::class, 'updateSchedule'])->name('schedules.update');
    });

// Staff Routes (Now ONLY handles their Dashboard/Section)
Route::middleware(['auth', 'role:staff'])->prefix('staff')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'index'])->name('staff.dashboard');
});

// Student Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/schedule', [StudentController::class, 'viewSchedule']);
});