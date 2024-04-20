<?php

namespace App\Http\Controllers;

use App\Models\RevisorDocuments;
use App\Http\Requests\StoreRevisorDocumentsRequest;
use App\Http\Requests\UpdateRevisorDocumentsRequest;

class RevisorDocumentsController extends Controller
{

    private string $routeName;
    private RevisorDocuments $model;
    private string $module = 'revisorDocs';

    public function __construct()
    {
        
        $this->model = new RevisorDocuments();
        $this->routeName = 'revisorDocs.';

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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRevisorDocumentsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRevisorDocumentsRequest $request)
    {
        //
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
    public function edit(RevisorDocuments $revisorDocuments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRevisorDocumentsRequest  $request
     * @param  \App\Models\RevisorDocuments  $revisorDocuments
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRevisorDocumentsRequest $request, RevisorDocuments $revisorDocuments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RevisorDocuments  $revisorDocuments
     * @return \Illuminate\Http\Response
     */
    public function destroy(RevisorDocuments $revisorDocuments)
    {
        //
    }
}
