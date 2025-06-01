<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\guestController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HandlingController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\ResolvedComplaintController;
use App\Http\Controllers\TechnicianHistoryController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route untuk Guest
// Route::get('/', function () {
//     return redirect('/guest');
// });

// Route::get('/guest', [GuestController::class, 'index'])->name('guest.index')->middleware('guest');
// Route::post('/guest', [GuestController::class, 'store'])->name('guest.store')->middleware('guest');
// Route::get('/guest/show/{id}', [GuestController::class, 'show'])->name('guest.show')->middleware('guest');
// Route::get('/guest/check-data', [GuestController::class, 'checkDataView'])->name('guest.checkDataView')->middleware('guest');
// Route::post('/guest/check-data', [GuestController::class, 'checkData'])->name('guest.checkDataPost')->middleware('guest');
// Route::get('/guest/check-data/{id}', [GuestController::class, 'checkDataResult'])->name('guest.checkDataResult')->middleware('guest');
// Route::get('/guest/download-pdf/{id}', [GuestController::class, 'downloadPdf'])->name('guest.download-pdf')->middleware('guest');

// // Route untuk Admin Login/Logout
// Route::get('/admin/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
// Route::post('/admin/login', [LoginController::class, 'login'])->name('login-post')->middleware('guest');
// Route::post('/admin/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// // Route untuk Dashboard Admin
// Route::get('/admin/dashboard', function () {
//     return view('admin.dashboard.index');
// })->name('dashboard')->middleware('auth');

// // Redirect untuk admin login
// Route::get('/admin', function () {
//     return redirect()->route('login');
// })->middleware('guest');

// Route::resource('/admin/complaint', ComplaintController::class)->middleware('aftersales');
// Route::post('/admin/complaint/export', [ComplaintController::class, 'export'])->name('complaint.export')->middleware('aftersales');
// Route::post('/admin/complaint/{complaint}/handle', [ComplaintController::class, 'handlingStore'])->name('complaint.handling-store')->middleware('aftersales');
// Route::patch('/admin/complaint/{complaint}/invalid', [ComplaintController::class, 'invalidData'])->name('complaint.invalid-data')->middleware('aftersales');

// Route::resource('/admin/handling', HandlingController::class)->middleware('aftersales');
// Route::post('/admin/handling/export', [HandlingController::class, 'export'])->name('handling.export')->middleware('aftersales');
// Route::post('/admin/handling/{handling}/reschedule', [HandlingController::class, 'rescheduleStore'])->name('handling.reschedule')->middleware('aftersales');
// Route::post('/admin/handling/{handling}/resolved-complaint', [HandlingController::class, 'resolvedComplaintStore'])->name('handling.resolved-complaint')->middleware('aftersales');
// Route::patch('/admin/handling/{handling}/repair-evidence-update', [HandlingController::class, 'repairEvidenceUpdate'])->name('handling.repair-evidence-update')->middleware('aftersales');
// Route::get('/admin/handling/{handling}/reschedule-histories', [HandlingController::class, 'rescheduleHistories'])->name('handling.reschedule-histories')->middleware('aftersales');

// Route::resource('/admin/resolved-complaint', ResolvedComplaintController::class)->middleware('aftersales');
// Route::post('/admin/resolved-complaint/export', [ResolvedComplaintController::class, 'export'])->name('resolved-complaint.export')->middleware('aftersales');
// Route::get('/admin/resolved-complaint/{resolved_complaint}/reschedule-histories', [ResolvedComplaintController::class, 'rescheduleHistories'])->name('resolved-complaint.reschedule-histories')->middleware('aftersales');

// Route::resource('/admin/technician-handling', TechnicianController::class)->middleware('technicians');
// Route::resource('/admin/technician-history', TechnicianHistoryController::class)->middleware('technicians');

// Route::post('/admin/sales/export', [SaleController::class, 'export'])->name('sales.export')->middleware('marketing');
// Route::get('/admin/sales/customer-search', [SaleController::class, 'customerSearch'])->name('customer-search')->middleware('marketing');
// Route::get('/admin/sales/product-search', [SaleController::class, 'productSearch'])->name('product-search')->middleware('marketing');
// Route::resource('/admin/sales', SaleController::class)->middleware('marketing');

// Route::resource('/admin/master-data/customers', CustomerController::class)->middleware('marketing');
// Route::resource('/admin/master-data/products', ProductController::class)->middleware('marketing');

// Route::resource('/admin/manage-users', UserController::class)->middleware('managerMarketing');


Route::get('/', function () {
    return redirect('/guest');
});

Route::get('/guest', [GuestController::class, 'index'])
    ->name('guest.index')->middleware('guest');
Route::post('/guest', [GuestController::class, 'store'])
    ->name('guest.store')->middleware('guest');
Route::get('/guest/show/{id}', [GuestController::class, 'show'])
    ->name('guest.show')->middleware('guest');
Route::get('/guest/check-data', [GuestController::class, 'checkDataView'])
    ->name('guest.checkDataView')->middleware('guest');
Route::post('/guest/check-data', [GuestController::class, 'checkData'])
    ->name('guest.checkDataPost')->middleware('guest');
Route::get('/guest/check-data/{id}', [GuestController::class, 'checkDataResult'])
    ->name('guest.checkDataResult')->middleware('guest');
Route::get('/guest/download-pdf/{id}', [GuestController::class, 'downloadPdf'])
    ->name('guest.download-pdf')->middleware('guest');

// Admin Login/Logout
Route::get('/admin/login', [LoginController::class, 'index'])
    ->name('login')->middleware('guest');
Route::post('/admin/login', [LoginController::class, 'login'])
    ->name('login-post')->middleware('guest');
Route::post('/admin/logout', [LoginController::class, 'logout'])
    ->name('logout')->middleware('auth');

// Admin Dashboard
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard.index');
})->name('dashboard')->middleware('auth');

Route::get('/admin', function () {
    return redirect()->route('login');
})->middleware('guest');

Route::resource('/admin/complaint', ComplaintController::class)
    ->middleware('aftersales');
Route::post('/admin/complaint/export', [ComplaintController::class, 'export'])
    ->name('complaint.export')->middleware('aftersales');
Route::post(
    '/admin/complaint/{complaint}/handle',
    [ComplaintController::class, 'handlingStore']
)
    ->name('complaint.handling-store')->middleware('aftersales');
Route::patch(
    '/admin/complaint/{complaint}/invalid',
    [ComplaintController::class, 'invalidData']
)
    ->name('complaint.invalid-data')->middleware('aftersales');

Route::resource('/admin/handling', HandlingController::class)
    ->middleware('aftersales');
Route::post('/admin/handling/export', [HandlingController::class, 'export'])
    ->name('handling.export')->middleware('aftersales');
Route::post(
    '/admin/handling/{handling}/reschedule',
    [HandlingController::class, 'rescheduleStore']
)
    ->name('handling.reschedule')->middleware('aftersales');
Route::post(
    '/admin/handling/{handling}/resolved-complaint',
    [HandlingController::class, 'resolvedComplaintStore']
)
    ->name('handling.resolved-complaint')->middleware('aftersales');
Route::patch(
    '/admin/handling/{handling}/repair-evidence-update',
    [HandlingController::class, 'repairEvidenceUpdate']
)
    ->name('handling.repair-evidence-update')->middleware('aftersales');
Route::get(
    '/admin/handling/{handling}/reschedule-histories',
    [HandlingController::class, 'rescheduleHistories']
)
    ->name('handling.reschedule-histories')->middleware('aftersales');

Route::resource('/admin/resolved-complaint', ResolvedComplaintController::class)
    ->middleware('aftersales');
Route::post(
    '/admin/resolved-complaint/export',
    [ResolvedComplaintController::class, 'export']
)
    ->name('resolved-complaint.export')->middleware('aftersales');
Route::get(
    '/admin/resolved-complaint/{resolved_complaint}/reschedule-histories',
    [ResolvedComplaintController::class, 'rescheduleHistories']
)
    ->name('resolved-complaint.reschedule-histories')->middleware('aftersales');

Route::resource('/admin/technician-handling', TechnicianController::class)
    ->middleware('technicians');
Route::resource('/admin/technician-history', TechnicianHistoryController::class)
    ->middleware('technicians');

Route::post('/admin/sales/export', [SaleController::class, 'export'])
    ->name('sales.export')->middleware('marketing');
Route::get('/admin/sales/customer-search', [SaleController::class, 'customerSearch'])
    ->name('customer-search')->middleware('marketing');
Route::get('/admin/sales/product-search', [SaleController::class, 'productSearch'])
    ->name('product-search')->middleware('marketing');
Route::resource('/admin/sales', SaleController::class)->middleware('marketing');

Route::resource('/admin/master-data/customers', CustomerController::class)
    ->middleware('marketing');
Route::resource('/admin/master-data/products', ProductController::class)
    ->middleware('marketing');

Route::resource('/admin/manage-users', UserController::class)
    ->middleware('managerMarketing');
