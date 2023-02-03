<?php

use App\Http\Controllers\AssestmentCriteriaController;
use App\Http\Controllers\ColonyController;
use App\Http\Controllers\DocumentSupportingController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\InstitutionsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Renapo;
use App\Http\Controllers\RenapoController;
use App\Models\Colony;
use App\Models\Document_Supporting;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::resource('renapo', RenapoController::class)->names('renapo');
Route::resource('colony', ColonyController::class)->names('colony');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    /*     Route::resource('roles', PermissionController::class)->names('roles');
 */

    Route::resource('institutions', InstitutionsController::class)->names('institutions');  
    Route::resource('permissions', PermissionController::class)->names('permissions');
    Route::resource('events', EventsController::class)->names('events');
    Route::resource('assesstment', AssestmentCriteriaController::class)->names('assesstment');
    Route::resource('documents', DocumentSupportingController::class)->names('documents');
});
