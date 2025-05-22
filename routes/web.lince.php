<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ContactsController;
use App\Http\Controllers\Admin\LeadsController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\QuotationController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ApponitmentsController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\QualifiedController;
use App\Http\Controllers\Admin\ClosedOrWonController;
use App\Http\Controllers\Admin\FollowUpController;
use App\Http\Controllers\Admin\DroppedOrCancelController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\OurLeadsController;
use App\Http\Controllers\Admin\LicenseController;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }
    return redirect()->route('admin.home');
});

Route::get('/test-job', function() {
    $lead = App\Models\Leads::first();
    \App\Jobs\SendFollowupEmailJob::dispatch($lead);
    return "Dispatched job for lead ID: {$lead->id}";
});

Auth::routes();

// License activation routes (outside admin group)
Route::middleware(['auth'])->group(function () {
    Route::get('/activate-license', [LicenseController::class, 'showActivationForm'])
        ->name('license.activate');

    Route::post('/activate-license', [LicenseController::class, 'activate'])
        ->name('admin.licenses.activate');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/licenses', [LicenseController::class, 'index']);
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'license']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Permissions
    Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', PermissionsController::class);

    // Roles
    Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', RolesController::class);

    // Users
    Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
    Route::resource('users', UsersController::class);

    // Contacts
    Route::delete('contacts/destroy', [ContactsController::class, 'massDestroy'])->name('contacts.massDestroy');
    Route::resource('contacts', ContactsController::class);

    // Reports
    Route::get('reports/export', [ReportsController::class, 'exportinreports'])->name('reports.export');
    Route::delete('reports/destroy', [ReportsController::class, 'massDestroy'])->name('reports.massDestroy');
    Route::resource('reports', ReportsController::class);

    // Leads
    Route::get('leads/export', [LeadsController::class, 'exportintoexcel'])->name('leads.export');
    Route::delete('leads/destroy', [LeadsController::class, 'massDestroy'])->name('leads.massDestroy');
    Route::resource('leads', LeadsController::class);

    // Our Leads
    Route::get('our-leads/export', [OurLeadsController::class, 'exportinourLeads'])->name('our-leads.export');
    Route::delete('our-leads/destroy', [OurLeadsController::class, 'massDestroy'])->name('our-leads.massDestroy');
    Route::resource('our-leads', OurLeadsController::class);

    // Products
    Route::get('products/bulk-import', [ProductsController::class, 'bulkImport'])->name('products.bulk-import');
    Route::post('products/bulk-import-store', [ProductsController::class, 'bulkImportStore'])->name('products.bulk-import-store');
    Route::delete('products/destroy', [ProductsController::class, 'massDestroy'])->name('products.massDestroy');
    Route::resource('products', ProductsController::class);

    // ProductCategory
    Route::delete('productCategory/destroy', [ProductCategoryController::class, 'massDestroy'])->name('productCategory.massDestroy');
    Route::resource('productCategory', ProductCategoryController::class);

    // Quotations
    Route::get('quotations/export', [QuotationController::class, 'exportinquotations'])->name('quotations.export');
    Route::delete('quotations/destroy', [QuotationController::class, 'massDestroy'])->name('quotations.massDestroy');
    Route::resource('quotations', QuotationController::class);
    Route::put('admin/quotations/{lead}', [QuotationController::class, 'update'])->name('quotations.update');
    Route::get('/quotations', [QuotationController::class, 'index'])->name('quotations.index');
    Route::post('/send-quotation/{id}', [QuotationController::class, 'sendQuotationEmail'])->name('send.quotation');

    Route::post('/send-demo/{leadId}', [ApponitmentsController::class, 'sendDemoEmail'])->name('send.demo');
    Route::post('/send-follow/{leadId}', [FollowUpController::class, 'sendFollowEmail'])->name('send.follow');

    // Appointments
    Route::get('appointments/export', [ApponitmentsController::class, 'exportinappointments'])->name('appointments.export');
    Route::delete('appointments/destroy', [ApponitmentsController::class, 'massDestroy'])->name('appointments.massDestroy');
    Route::resource('appointments', ApponitmentsController::class);

    // ClosedOrWon
    Route::get('closedOrWon/export', [ClosedOrWonController::class, 'exportinclosedOrWon'])->name('closedOrWon.export');
    Route::delete('closedOrWon/destroy', [ClosedOrWonController::class, 'massDestroy'])->name('closedOrWon.massDestroy');
    Route::resource('closedOrWon', ClosedOrWonController::class);

    // DroppedOrCancel
    Route::get('droppedOrCancel/export', [DroppedOrCancelController::class, 'exportinDroppedOrCancel'])->name('droppedOrCancel.export');
    Route::delete('droppedOrCancel/destroy', [DroppedOrCancelController::class, 'massDestroy'])->name('droppedOrCancel.massDestroy');
    Route::resource('droppedOrCancel', DroppedOrCancelController::class);

    // FollowUp
    Route::get('followUp/export', [FollowUpController::class, 'exportinfollowUp'])->name('followUp.export');
    Route::delete('followUp/destroy', [FollowUpController::class, 'massDestroy'])->name('followUp.massDestroy');
    Route::resource('followUp', FollowUpController::class);

    // Qualified
    Route::get('qualified/export', [QualifiedController::class, 'exportinQualified'])->name('qualified.export');
    Route::delete('qualified/destroy', [QualifiedController::class, 'massDestroy'])->name('qualified.massDestroy');
    Route::resource('qualified', QualifiedController::class);

    Route::get('admin/leads/{lead}/products', [LeadsController::class, 'getProducts'])->name('leads.products');
    Route::get('/leads/get-assigned-name', [LeadsController::class, 'getAssignedName'])->name('leads.getAssignedName');
    Route::get('/lead/{id}', [LeadsController::class, 'getLeadDetails']);
    Route::get('/leads/{id}/products', [LeadsController::class, 'getLeadProducts']);

    // License Management Routes
    Route::prefix('licenses')->group(function () {
        Route::get('/', [LicenseController::class, 'index'])->name('licenses.index');
        Route::get('/create', [LicenseController::class, 'create'])->name('licenses.create');
        Route::post('/', [LicenseController::class, 'store'])->name('licenses.store');
        Route::get('/{license}', [LicenseController::class, 'show'])->name('licenses.show');
        Route::get('/{license}/edit', [LicenseController::class, 'edit'])->name('licenses.edit');
        Route::put('/{license}', [LicenseController::class, 'update'])->name('licenses.update');
        Route::delete('/{license}', [LicenseController::class, 'destroy'])->name('licenses.destroy');
        Route::get('/{license}/download', [LicenseController::class, 'download'])->name('licenses.download');
        Route::post('/bulk-generate', [LicenseController::class, 'bulkGenerate'])->name('licenses.bulkGenerate');
        Route::post('/{license}/toggle-status', [LicenseController::class, 'toggleStatus'])->name('licenses.toggleStatus');
    });

    // License check API
    Route::get('/api/license/check', [LicenseController::class, 'check']);
});

Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['auth']], function () {
    Route::get('password', [ChangePasswordController::class, 'edit'])->name('password.edit');
    Route::get('change-password', [ChangePasswordController::class, 'password'])->name('password.change-password');
    Route::post('password', [ChangePasswordController::class, 'update'])->name('password.update');
    Route::post('profile', [ChangePasswordController::class, 'updateProfile'])->name('password.updateProfile');
    Route::post('profile/destroy', [ChangePasswordController::class, 'destroy'])->name('password.destroyProfile');
});
