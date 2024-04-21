<?php

namespace App\Http\Controllers;

use App\Models\RevisorDocuments;
use App\Http\Requests\StoreRevisorDocumentsRequest;
use App\Http\Requests\UpdateRevisorDocumentsRequest;
use Illuminate\Http\Request;
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
        $this->middleware("role:Admin");

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

        return Inertia::render("{$this->source}Index", [
            'titulo'          => 'Documentacion para Evaluadores',
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
