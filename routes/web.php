<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FrontdeskController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
//Route::post('login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/session/store', [FrontdeskController::class, 'storeSession'])->name('session.store');
Route::get('/frontdesk/dashboard', [FrontdeskController::class, 'dashboard'])->name('frontdesk.dashboard');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctorsinfo', [DoctorController::class, 'dashboard'])->name('doctors.dashboard');
Route::get('/doctor/profile', [DoctorController::class, 'show'])->name('doctor.profile.show');
Route::get('/doctor/edit', [DoctorController::class, 'edit'])->name('doctor.edit');
Route::put('/doctor/update', [DoctorController::class, 'update'])->name('doctor.update');
Route::post('/profile/upload', [DoctorController::class, 'upload'])->name('profile.upload');
Route::get('/frontdesk/appointments', [AppointmentController::class, 'index'])
    ->name('appointments.index');
Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.doctors');


//Superadmin
Route::get('/superadmin/dashboard', [FrontdeskController::class, 'dashboard'])->name('superadmin.dashboard');
Route::get('/superadmin/appointments', [AppointmentController::class, 'index'])->name('superadmin.appointments');
Route::get('/superadmin/patients', [PatientController::class, 'index'])->name('superadmin.index');
Route::get('/superadmin/profile', [DashboardController::class, 'show'])->name('superadmin.profile');
Route::get('/superadmin/edit', [DashboardController::class, 'edit'])->name('superadmin.edit');
Route::put('/superadmin/update', [DashboardController::class, 'update'])->name('superadmin.update');
Route::get('/superadmin/doctors', [DoctorController::class, 'index'])->name('superadmin.doctors');
Route::get('/superadmin/billing', [BillingController::class, 'index'])->name('superadmin.billing');
Route::get('/superadmin/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/superadmin/suppliers', [SupplierController::class, 'index'])->name('superadmin.suppliers');
Route::get('/superadmin/units', [UnitController::class, 'index'])->name('superadmin.units');
Route::get('/superadmin/productcategories', [ProductCategoryController::class, 'index'])->name('productcategories.index');
Route::get('/superadmin/purchases', [PurchaseController::class, 'index'])->name('superadmin.purchases');
Route::get('/superadmin/users', [UsersController::class, 'index'])->name('superadmin.users');

//Route::get('/superadmin/purchage', [ProductController::class, 'index'])->name('superadmin.purchage');



//Admin
Route::get('/admin/dashboard', [FrontdeskController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/appointments', [AppointmentController::class, 'index'])->name('admin.appointments');
Route::get('/admin/patients', [PatientController::class, 'index'])->name('admin.patients');
Route::get('/admin/profile', [DashboardController::class, 'show'])->name('admin.profile');
Route::get('/admin/edit', [DashboardController::class, 'edit'])->name('admin.edit');
Route::put('/admin/update', [DashboardController::class, 'update'])->name('admin.update');
Route::get('/admin/doctors', [DashboardController::class, 'doctors'])->name('admin.doctors');
Route::get('/admin/billing', [BillingController::class, 'index'])->name('admin.billing');


//Frontdesk
Route::get('/frontdesk/dashboard', [FrontdeskController::class, 'dashboard'])->name('frontdesk.dashboard');
Route::get('/frontdesk/appointments', [AppointmentController::class, 'index'])->name('frontdesk.appointments');
Route::get('/frontdesk/doctors', [DoctorController::class, 'index'])->name('frontdesk.doctors');
Route::get('/frontdesk/profile', [DashboardController::class, 'show'])->name('frontdesk.profile');
Route::get('/frontdesk/edit', [DashboardController::class, 'edit'])->name('frontdesk.edit');
Route::put('/frontdesk/update', [DashboardController::class, 'update'])->name('frontdesk.update');

//Pharmacy
Route::get('/pharma/billing', [BillingController::class, 'index'])->name('pharma.billing');
Route::get('/pharma/medicines', [ProductController::class, 'index'])->name('pharma.products');
Route::get('/pharma/purchases', [PurchaseController::class, 'index'])->name('pharma.purchases');
Route::get('/pharma/dashboard', [FrontdeskController::class, 'pharmaDashboard'])->name('pharma.dashboard');
Route::get('/pharma/profile', [DashboardController::class, 'show'])->name('pharma.profile');
Route::get('/pharma/edit', [DashboardController::class, 'edit'])->name('pharma.edit');
Route::put('/pharma/update', [DashboardController::class, 'update'])->name('pharma.update');
