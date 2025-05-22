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


Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/licenses', [LicenseController::class, 'index']);
});


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {

        Route::post('/license/activate', [LicenseController::class, 'activate']);
        Route::post('/license/renew', [LicenseController::class, 'renewLicense']);

        Route::get('/', [HomeController::class, 'index'])->name('home');

        Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
        Route::resource('permissions', PermissionsController::class);

        // Roles
        Route::delete('roles/destroy', [RolesController::class, 'massDestroy'])->name('roles.massDestroy');
        Route::resource('roles', RolesController::class);

        // Users
        Route::delete('users/destroy', [UsersController::class, 'massDestroy'])->name('users.massDestroy');
        Route::resource('users', UsersController::class);

        // Contacts routes
        Route::delete('contacts/destroy', [ContactsController::class, 'massDestroy'])->name('contacts.massDestroy');
        Route::resource('contacts', ContactsController::class);

        // Reports routes
        Route::get('reports/export', [ReportsController::class, 'exportinreports'])->name('reports.export');
        Route::delete('reports/destroy', [ReportsController::class, 'massDestroy'])->name('reports.massDestroy');
        Route::resource('reports', ReportsController::class);

        // Leads routes
        Route::get('leads/export', [LeadsController::class, 'exportintoexcel'])->name('leads.export');
        Route::delete('leads/destroy', [LeadsController::class, 'massDestroy'])->name('leads.massDestroy');
        Route::resource('leads', LeadsController::class);

        Route::post('leads/{lead}/toggle-pin', [LeadsController::class, 'togglePin'])->name('leads.toggle-pin');

        // Our Leads routes
        Route::get('our-leads/export', [OurLeadsController::class, 'exportinourLeads'])->name('our-leads.export');
        Route::delete('our-leads/destroy', [OurLeadsController::class, 'massDestroy'])->name('our-leads.massDestroy');
        Route::resource('our-leads', OurLeadsController::class);
        // Route::post('our-leads/{lead}/toggle-pin', [OurLeadsController::class, 'togglePin'])->name('our-leads.toggle-pin');


        // Products
        Route::get('products/bulk-import', [ProductsController::class, 'bulkImport'])->name('products.bulk-import');
        Route::post('products/bulk-import-store', [ProductsController::class, 'bulkImportStore'])->name('products.bulk-import-store');

        Route::delete('products/destroy', [ProductsController::class, 'massDestroy'])->name('products.massDestroy');
        Route::resource('products', ProductsController::class);

         // ProductCategory
         Route::delete('productCategory/destroy', [ProductCategoryController::class, 'massDestroy'])->name('productCategory.massDestroy');
         Route::resource('productCategory', ProductCategoryController::class);

        // Quatation routes
        Route::get('quotations/export', [QuotationController::class, 'exportinquotations'])->name('quotations.export');
        Route::delete('quotations/destroy', [QuotationController::class, 'massDestroy'])->name('quotations.massDestroy');
        Route::resource('quotations', QuotationController::class);
        Route::put('admin/quotations/{lead}', [QuotationController::class, 'update'])->name('quotations.update');
        Route::post('quotations/{lead}/toggle-pin', [QuotationController::class, 'togglePin'])->name('quotations.toggle-pin');

        Route::get('/quotations', [QuotationController::class, 'index'])->name('quotations.index');
        Route::post('/send-quotation/{id}', [QuotationController::class, 'sendQuotationEmail'])->name('send.quotation');


        Route::post('/send-demo/{leadId}', [ApponitmentsController::class, 'sendDemoEmail'])->name('send.demo');

        Route::post('/send-follow/{leadId}', [FollowUpController::class, 'sendFollowEmail'])->name('send.follow');

        // Appointments routes
        Route::get('appointments/export', [ApponitmentsController::class, 'exportinappointments'])->name('appointments.export');
        Route::delete('appointments/destroy', [ApponitmentsController::class, 'massDestroy'])->name('appointments.massDestroy');
        Route::resource('appointments', ApponitmentsController::class);
        Route::post('appointments/{lead}/toggle-pin', [ApponitmentsController::class, 'togglePin'])->name('appointments.toggle-pin');

      // ClosedOrWonController routes
        Route::get('closedOrWon/export', [ClosedOrWonController::class, 'exportinclosedOrWon'])->name('closedOrWon.export');
        Route::delete('closedOrWon/destroy', [ClosedOrWonController::class, 'massDestroy'])->name('closedOrWon.massDestroy');
        Route::resource('closedOrWon', ClosedOrWonController::class);
        Route::post('closedOrWon/{lead}/toggle-pin', [ClosedOrWonController::class, 'togglePin'])->name('closedOrWon.toggle-pin');

        // droppedOrCancel routes
        Route::get('droppedOrCancel/export', [DroppedOrCancelController::class, 'exportinDroppedOrCancel'])->name('droppedOrCancel.export');
        Route::delete('droppedOrCancel/destroy', [DroppedOrCancelController::class, 'massDestroy'])->name('droppedOrCancel.massDestroy');
        Route::resource('droppedOrCancel', DroppedOrCancelController::class);

        // flowup routes
        Route::get('followUp/export', [FollowUpController::class, 'exportinfollowUp'])->name('followUp.export');
        Route::delete('followUp/destroy', [FollowUpController::class, 'massDestroy'])->name('followUp.massDestroy');
        Route::resource('followUp', FollowUpController::class);

        // qualified routes
        Route::get('qualified/export', [QualifiedController::class, 'exportinQualified'])->name('qualified.export');
        Route::delete('qualified/destroy', [QualifiedController::class, 'massDestroy'])->name('qualified.massDestroy');
        Route::resource('qualified', QualifiedController::class);
        Route::post('qualified/{lead}/toggle-pin', [QualifiedController::class, 'togglePin'])->name('qualified.toggle-pin');


        Route::get('admin/leads/{lead}/products', [LeadsController::class, 'getProducts'])->name('leads.products');
//
        Route::get('/leads/get-assigned-name', [LeadsController::class, 'getAssignedName'])
        ->name('leads.getAssignedName');

        Route::get('/lead/{id}', [LeadsController::class, 'getLeadDetails']);
        Route::get('/leads/{id}/products', [LeadsController::class, 'getLeadProducts']);

        // excel
        // Route::post('/products/import', [ProductsController::class, 'importExcel'])->name('products.import');



});

    Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['auth']], function () {
    Route::get('password', [ChangePasswordController::class, 'edit'])->name('password.edit');
    Route::get('change-password', [ChangePasswordController::class, 'password'])->name('password.change-password');
    Route::post('password', [ChangePasswordController::class, 'update'])->name('password.update');
    Route::post('profile', [ChangePasswordController::class, 'updateProfile'])->name('password.updateProfile');
    Route::post('profile/destroy', [ChangePasswordController::class, 'destroy'])->name('password.destroyProfile');
});