<?php

namespace App\Http\Controllers;

use App\Models\Proposals;
use App\Http\Requests\StoreProposalsRequest;
use App\Http\Requests\UpdateProposalsRequest;
use App\Models\Announcements;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProposalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private string $routeName;
    private Proposals $model;
    private string $module = 'proposals';

    public function __construct()
    {
        $this->middleware('auth');
        $this->model = new Proposals();
        $this->routeName = 'proposals.';

        /*   $this->middleware("permission:{$this->module}.index")->only(['index', 'show']);
         $this->middleware("permission:{$this->module}.store")->only(['store', 'create']);
         $this->middleware("permission:{$this->module}.update")->only(['update', 'edit']);
         $this->middleware("permission:{$this->module}.delete")->only(['destroy', 'edit']);  */
    }

    public function index(Request $request): Response
    {
        $records = new Announcements();
        $records = $records->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
            }
        })->paginate(4)->withQueryString();

        return Inertia::render("Anouncement/Index", [
            'titulo'      => 'Selecciona una convocatoria',
            'records'    => $records->load('institutions'),
            'routeName'      => $this->routeName,
            'loadingResults' => false
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Announcements $record)
    {
        return Inertia::render("Proposals/Create", [
            'titulo'      => 'Gestions de documentacion',
            'routeName'      => $this->routeName,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProposalsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProposalsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proposals  $proposals
     * @return \Illuminate\Http\Response
     */
    public function show(Proposals $proposals)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proposals  $proposals
     * @return \Illuminate\Http\Response
     */
    public function edit(Proposals $proposals)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProposalsRequest  $request
     * @param  \App\Models\Proposals  $proposals
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProposalsRequest $request, Proposals $proposals)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proposals  $proposals
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proposals $proposals)
    {
        //
    }
}
