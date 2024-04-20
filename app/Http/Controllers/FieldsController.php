<?php

namespace App\Http\Controllers;

use App\Models\Fields;
use App\Http\Requests\StoreFieldsRequest;
use App\Http\Requests\UpdateFieldsRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FieldsController extends Controller
{

    protected string $routeName;
    protected string $source;
    protected string $module = 'fields';
    protected Fields $model;

    public function __construct()
    {
        $this->routeName = "fields.";
        $this->source    = "Fields/";
        $this->model     = new Fields();


        /*   $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
        $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
        $this->middleware("permission:{$this->module}.update")->only(['edit', 'update']);
        $this->middleware("permission:{$this->module}.delete")->only(['destroy']); */
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
                $query->where('title',          'LIKE', "%$search%");
            }
        })->paginate(5)->withQueryString();

        return Inertia::render("{$this->source}Index", [
            'titulo'          => 'Campos de Laboratorio',
            'fields'        => $records,
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
            'titulo' => 'Agregar Campos',
            'routeName' => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFieldsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFieldsRequest $request)
    {
        $this->model::create($request->validated());
        return redirect()->route("{$this->routeName}index")->with('success', 'Campo guardado con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fields  $fields
     * @return \Illuminate\Http\Response
     */
    public function show(Fields $fields)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fields  $fields
     * @return \Illuminate\Http\Response
     */
    public function edit(Fields $field)
    {
        return Inertia::render("{$this->source}Edit", [
            'titulo'          => 'Editar Campos de Laboratorios',
            'routeName'      => $this->routeName,
            'field' => $field,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFieldsRequest  $request
     * @param  \App\Models\Fields  $fields
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFieldsRequest $request, Fields $field)
    {
        $field->update($request->validated());
        return redirect()->route("{$this->routeName}index")
            ->with('success', 'Campo editado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fields  $fields
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fields $field)
    {
        $field->delete();
        return redirect()->route("{$this->routeName}index")
            ->with('success', 'Campo eliminado correctamente');
    }
}
