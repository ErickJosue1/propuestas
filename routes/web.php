<?php

use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\AssestmentCriteriaController;
use App\Http\Controllers\ColonyController;
use App\Http\Controllers\DocumentSupportingController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\InstitutionsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalsController;
use App\Http\Controllers\RenapoController;
use App\Models\Announcements;
use App\Models\Proposals;
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
        'records' => Announcements::paginate(4)->withQueryString()->load('institutions')
    ]);
});

Route::resource('renapo', RenapoController::class)->names('renapo');
Route::resource('colony', ColonyController  ::class)->names('colony');

Route::get('/dashboard', function () {
    return Inertia::render('HomeView');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {

    Route::get('/forms', function () {
        return Inertia::render('FormsView');
    });
    Route::get('/tables', function () {
        return Inertia::render('TablesView');
    });
    Route::get('/ui', function () {
        return Inertia::render('UiView');
    });
    Route::get('/responsive', function () {
        return Inertia::render('ResponsiveView');
    });
    Route::get('/profile', function () {
        return Inertia::render('ProfileView');
    });
    Route::get('/error', function () {
        return Inertia::render('ErrorView');
    });

    /* Route::get('/', function () {
        return Inertia::render('StyleView');
    }); */


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('institutions', InstitutionsController::class)->names('institutions');
    Route::resource('announcements', AnnouncementsController::class)->names('announcements');
    Route::resource('permissions', PermissionController::class)->names('permissions');
    Route::resource('events', EventsController::class)->names('events');
    Route::resource('assesstment', AssestmentCriteriaController::class)->names('assesstment');
    Route::resource('documents', DocumentSupportingController::class)->names('documents');
    Route::resource('proposals', ProposalsController::class)->names('proposals');

});

require __DIR__ . '/auth.php';
