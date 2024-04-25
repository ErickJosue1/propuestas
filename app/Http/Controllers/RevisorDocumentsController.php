<?php

namespace App\Http\Controllers;

use App\Models\RevisorDocuments;
use App\Http\Requests\StoreRevisorDocumentsRequest;
use App\Http\Requests\UpdateRevisorDocumentsRequest;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class RevisorDocumentsController extends Controller
{

    private string $routeName;
    private RevisorDocuments $model;
    private string $module = 'revisorDocs';
    protected string $source;

    public function __construct()
    {

        $this->model = new RevisorDocuments();
        $this->routeName = 'revisorDocs.';
        $this->source    = "RevisorDocs/";

        /*  $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
         $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
         $this->middleware("permission:{$this->module}.update")->only(['update', 'edit']);
         $this->middleware("permission:{$this->module}.delete")->only(['destroy', 'edit']);  */
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): Response
    {
        $records = $this->model;
        $records = $records->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
            }
        })->paginate(5)->withQueryString();

        $route = "Index";
        $title = "Documentacion para Evaluadores";

        if (User::find(Auth::user()->id)->hasRole("Revisor")) {
            $route = "ReviewIndex";
            $title = "Revision de documentacion";
            $records = User::whereHas('status')->with('statusId')->paginate(5)->withQueryString();
        }

        return Inertia::render("{$this->source}{$route}", [
            'titulo'          => $title,
            'revisorDocs'        => $records,
            'routeName'      => $this->routeName,
            'loadingResults' => false,
            'search'         => $request->search ?? '',
            'status'         => (bool) $request->status,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("{$this->source}Create", [
            'titulo' => 'Agregar Documento',
            'routeName' => $this->routeName,
        ]);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRevisorDocumentsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRevisorDocumentsRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Documento guardado con éxito!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function review(User $userId)
    {

        $documents = RevisorDocuments::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId->id);
        })->get();

        return Inertia::render("{$this->source}Review", [
            'titulo' => 'Revisar Documentacion',
            'revisorDocs' => $documents,
            'user' => $userId,
            'routeName' => $this->routeName,
        ]);
    }

    /* 
        Send the specified document file to the view
    */

    public function downloadPdf($filename, $user)
    {
        $pathToFile = storage_path('Evaluadores/' . User::find($user)->name . ' Documentos' . '/' . $filename);

        return response()->download($pathToFile);
    }

    /* 
        Give the specified document file path to the view
    */

    public function viewPdf($filename, $user)
    {
        $pathToFile = storage_path('Evaluadores/' . User::find($user)->name . ' Documentos' . '/' . $filename);

        return response()->make(file_get_contents($pathToFile), 200, [
            'Content-Type'        => mime_content_type($pathToFile),
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function storeDocument(Request $request)
    {
        $user = User::find(Auth::user()->id);

        foreach ($request->myFiles as $files) {
            $contenidoArchivo = file_get_contents($files);
            Storage::disk("evaluadores")->put($user->name . ' Documentos/' . $files->getClientOriginalName(), $contenidoArchivo);
        }
    }


    /**
     * Display the specified resource.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function updateStatus()
    {
        $userId = Auth::user()->id;
        $user = User::find(Auth::user()->id);

        $documents = RevisorDocuments::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->get();

        foreach ($documents as $value) {

            $status = 0;

            if (Storage::disk("evaluadores")->exists($user->name . ' Documentos/' . $value['name'] . '.pdf')) {
                $status = 1;
            }

            $doc = RevisorDocuments::find($value['id']);

            if ($doc->users()->wherePivot('user_id', $userId)->exists()) {
                $doc->users()->updateExistingPivot($userId, ['status' => $status]);
            }
        }

        return redirect()->route("{$this->routeName}documents")->with('success', 'Documentos subidos con éxito!');
    }


    /**
     * Display the specified resource.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function assign(Request $request)
    {

        $users = User::role("Evaluador")->get();

        foreach ($users as $user) {

            $directory = storage_path('Evaluadores/' . $user->name . ' Documentos');

            if (!File::isDirectory($directory)) {
                Storage::disk("evaluadores")->makeDirectory($user->name . ' Documentos');
            }

            foreach ($request->documents as $value) {
                $status = 0;

                if (Storage::disk("evaluadores")->exists($user->name . ' Documentos/' . $value['name'] . '.pdf')) {
                    $status = 1;
                }

                $doc = RevisorDocuments::find($value['id']);

                if (!$doc->users()->wherePivot('user_id', $user->id)->exists()) {
                    $doc->users()->attach($user->id, ['path' => $directory, 'status' => $status]);
                }
            }
        }



        return redirect()->route("{$this->routeName}index")->with('success', 'Documentos asignados con éxito!');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RevisorDocuments  $revisorDocuments
     * @return \Illuminate\Http\Response
     */
    public function show(RevisorDocuments $revisorDocuments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RevisorDocuments  $revisorDocuments
     * @return \Illuminate\Http\Response
     */
    public function edit(RevisorDocuments $revisorDoc)
    {
        return Inertia::render("{$this->source}Edit", [
            'titulo'          => 'Editar Soporte a documentos para revisores',
            'routeName'      => $this->routeName,
            'revisorDoc' => $revisorDoc,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRevisorDocumentsRequest  $request
     * @param  \App\Models\RevisorDocuments  $revisorDocuments
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRevisorDocumentsRequest $request, RevisorDocuments $revisorDoc)
    {
        $revisorDoc->update($request->validated());
        return redirect()->route("{$this->routeName}index")
            ->with('success', 'Documento editado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RevisorDocuments  $revisorDocuments
     * @return \Illuminate\Http\Response
     */
    public function destroy(RevisorDocuments $revisorDoc)
    {
        $revisorDoc->delete();
        return redirect()->route("{$this->routeName}index")
            ->with('success', 'Documento eliminado correctamente');
    }
}
