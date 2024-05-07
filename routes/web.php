<?php

use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\AreasKnowledgeController;
use App\Http\Controllers\AssestmentCriteriaController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ColonyController;
use App\Http\Controllers\CriteriasController;
use App\Http\Controllers\DocumentSupportingController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\FieldsController;
use App\Http\Controllers\InstitutionsController;
use App\Http\Controllers\PdfGenerate;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalsController;
use App\Http\Controllers\RenapoController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RevisorDocumentsController;
use App\Http\Controllers\RevisorStatusController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Models\Announcements;
use App\Models\Areas_knowledge;
use App\Models\Calendar;
use App\Models\Fields;
use App\Models\Proposals;
use App\Models\review;
use App\Models\RevisorDocuments;
use App\Models\RevisorStatus;
use App\Models\User;
use App\Models\user_revisorDocument;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use function GuzzleHttp\Promise\all;

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
        'records' => Announcements::paginate(3)->withQueryString()->load('institutions', 'assesstment_criterias', 'documents_supporting', 'calendars')
    ]);
});

Route::resource('renapo', RenapoController::class)->names('renapo');
Route::resource('colony', ColonyController::class)->names('colony');
Route::get('/download-AdPdf/{filename}/{announcement}', [AnnouncementsController::class, 'downloadPdf'])->name('download-AdPdf');

//Annoucement Image Display
Route::get('/view-image/{filename}/{announcement}', [AnnouncementsController::class, 'viewImage'])->name('view-image');

Route::get('/dashboard', function () {
    return Inertia::render('HomeView', ['users' => User::all(), 'announcements' =>  Announcements::all(), 'proposals' => Proposals::all()]);
})->middleware(['auth', 'verified', 'role:Admin'])->name('dashboard');


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
    }); */

    //Views and downloads of proposal's recognition
    Route::get('/generate-pdf/{proposal}', [PdfGenerate::class, 'recognitionPDF'])->name('recognitionPDF');
    Route::get('/download-pdf/{proposal}', [PdfGenerate::class, 'downloadRecognitionPDF'])->name('downloadRecognitionPDF');
    Route::get('/generate', [PdfGenerate::class, 'testQR'])->name('testQR');



    //Sync reviewrs
    Route::post('/proposals/sync', [ProposalsController::class, 'syncReviewrs'])->name('proposals.sync');

    //Assign Documents
    Route::post('/revisorDocs/assign', [RevisorDocumentsController::class, 'assign'])->name('revisorDocs.assign');

    //Assign Documents
    Route::get('/revisorDocs/updateStatus', [RevisorDocumentsController::class, 'updateStatus'])->name('revisorDocs.updateStatus');

    //Review Evaluador documents
    Route::get('/revisorDocs/{userId}/review', [RevisorDocumentsController::class, 'review'])->name('revisorDocs.review');

    //Upload Evaluator document
    Route::post('/revisorDocs/storeDocument', [RevisorDocumentsController::class, 'storeDocument'])->name('revisorDocs.storeDocument');

    //Assign status
    Route::post('/revisorStatus/{userId}/assign/', [RevisorStatusController::class, 'store'])->name('revisorStatus.assign');


    //Asign roles
    Route::get('/users/{user}/assign-roles-and-permissions', [UserController::class, 'assignRolesAndPermissionsView'])->name('users.assign-roles-and-permissions.view');
    Route::post('/users/{user}/assign-roles-and-permissions', [UserController::class, 'assignRolesAndPermissions'])->name('users.assign-roles-and-permissions');

    //Admin user management
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile/store', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/{user}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/{userId}/assign-role', [ProfileController::class, 'assignRole'])->name('profile.assignRole');

    //Views and downloads of evaluator's documents
    Route::get('/download-pdf/{filename}/{user}', [RevisorDocumentsController::class, 'downloadPdf'])->name('downloadEvaluator-pdf');
    Route::get('/view-pdf/{filename}/{user}', [RevisorDocumentsController::class, 'viewPdf'])->name('viewEvaluator-pdf');

    //Views and downloads of proposal's documents
    Route::get('/download-pdf/{filename}/{user}/{announcement}', [ProposalsController::class, 'downloadPdf'])->name('download-pdf');
    Route::get('/view-pdf/{filename}/{user}/{announcement}', [ProposalsController::class, 'viewPdf'])->name('view-pdf');
    Route::get('/view-AdPdf/{filename}/{announcement}', [AnnouncementsController::class, 'viewPdf'])->name('view-AdPdf');



    //Non resource porposal routes 
    Route::put('/proposals/{proposal}/updateReview', [ProposalsController::class, 'updateReview'])->name('proposals.updateReview');
    Route::get('/proposals/{proposal}/assign', [ProposalsController::class, 'assignment'])->name('proposals.assignment');
    Route::get('/proposals/{proposal}/review', [ProposalsController::class, 'review'])->name('proposals.review');
    Route::get('/proposals/{proposal}/state', [ProposalsController::class, 'getState'])->name('proposals.getState');


    //Evaluator Documents

    Route::get('/RevisorDocs/Documents', function () {
        return Inertia::render('RevisorDocs/Documents', [
            'titulo'          => 'Tu Documentacion',
            'records' =>  RevisorDocuments::whereHas('users', function ($query) {
                $query->where('user_id', Auth::user()->id);
            })->get(),
            'documents' => user_revisorDocument::where('user_id', Auth::user()->id)->get()->mapWithKeys(function ($record) {
                return [$record['revisor_documents_id'] => $record['status']];
            }),
            'routeName'      => "revisorDocs.",
            'status'       => RevisorStatus::where("user_id", Auth::user()->id)->get(),
        ]);
    })->middleware("role:Evaluador")->name('revisorDocs.documents');

    //Main routes
    Route::resource('reviews', ReviewController::class)->names('reviews');
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
    Route::resource('revisorDocs', RevisorDocumentsController::class)->names('revisorDocs');
    Route::resource('fields', FieldsController::class)->names('fields');
});

require __DIR__ . '/auth.php';
