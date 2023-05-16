<?php

use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\AreasKnowledgeController;
use App\Http\Controllers\AssestmentCriteriaController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ColonyController;
use App\Http\Controllers\CriteriasController;
use App\Http\Controllers\DocumentSupportingController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\InstitutionsController;
use App\Http\Controllers\PdfGenerate;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalsController;
use App\Http\Controllers\RenapoController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Models\Announcements;
use App\Models\Areas_knowledge;
use App\Models\Calendar;
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
Route::resource('colony', ColonyController::class)->names('colony');
Route::get('/download-AdPdf/{filename}/{announcement}', [AnnouncementsController::class, 'downloadPdf'])->name('download-AdPdf');


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

    /*   Route::get('/', function () {
        return Inertia::render('StyleView');
    });  */


    Route::get('/generate-pdf/{proposal}', [PdfGenerate::class, 'recognitionPDF'])->name('recognitionPDF');
    Route::get('/download-pdf/{proposal}', [PdfGenerate::class, 'downloadRecognitionPDF'])->name('downloadRecognitionPDF');
    
    Route::get('/users/{user}/assign-roles-and-permissions', [UserController::class, 'assignRolesAndPermissionsView'])->name('users.assign-roles-and-permissions.view');
    Route::post('/users/{user}/assign-roles-and-permissions', [UserController::class, 'assignRolesAndPermissions'])->name('users.assign-roles-and-permissions');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/download-pdf/{filename}/{user}/{announcement}', [ProposalsController::class, 'downloadPdf'])->name('download-pdf');
    Route::get('/view-pdf/{filename}/{user}/{announcement}', [ProposalsController::class, 'viewPdf'])->name('view-pdf');
    Route::get('/view-AdPdf/{filename}/{announcement}', [AnnouncementsController::class, 'viewPdf'])->name('view-AdPdf');

    Route::put('/proposals/{proposal}', [ProposalsController::class, 'updateReview'])->name('proposals.updateReview');
    Route::get('/proposals/{proposal}/assign', [ProposalsController::class, 'assignment'])->name('proposals.assignment');
    Route::get('/proposals/{proposal}/review', [ProposalsController::class, 'review'])->name('proposals.review');

    Route::resource('institutions', InstitutionsController::class)->names('institutions');
    Route::resource('announcements', AnnouncementsController::class)->names('announcements');
    Route::resource('permissions', PermissionController::class)->names('permissions');
    Route::resource('roles', RolesController::class)->names('roles');
    Route::resource('events', EventsController::class)->names('events');
    Route::resource('assesstment', AssestmentCriteriaController::class)->names('assesstment');
    Route::resource('documents', DocumentSupportingController::class)->names('documents');
    Route::resource('proposals', ProposalsController::class)->names('proposals');
    Route::resource('calendar', CalendarController::class)->names('calendar');
    Route::resource('criterias', CriteriasController::class)->names('criterias');
    Route::resource('knowledges', AreasKnowledgeController::class)->names('knowledges');
});

require __DIR__ . '/auth.php';
