<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LeadsController;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your app lication. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
    */
Route::post('leads', [LeadsController::class, 'store'])->withoutMiddleware(['auth:sanctum']);


