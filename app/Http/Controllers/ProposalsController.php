<?php

namespace App\Http\Controllers;

use App\Models\Proposals;
use App\Http\Requests\StoreProposalsRequest;
use App\Http\Requests\UpdateProposalsRequest;
use App\Models\Announcements;
use App\Models\Assestment_Criteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $records = new Proposals();
        $records = $records->when($request->search, function ($query, $search) {
            if ($search != '') {
                $query->where('name',          'LIKE', "%$search%");
            }
        })->paginate(4)->withQueryString();

        return Inertia::render("Proposals/Index", [
            'titulo'      => 'Tus Propuestas',
            'records'    => $records,
            'routeName'      => $this->routeName,
            'loadingResults' => false,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Announcements $record)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProposalsRequest $request)
    {

        $this->model::create($request->validated());

        foreach ($request->myFiles as $files) {
          /*   mimes:jpg,bmp,png */
          
            $files->storeAs(Auth::user()->name . 'Expediente', $files->getClientOriginalName(), 'public');
        }

        return redirect()->route("{$this->routeName}index")->with('success', 'Su propuesta ha sido guardada con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proposals  $proposals
     * @return \Illuminate\Http\Response
     */
    public function show(Announcements $proposal)
    {

        return Inertia::render("Proposals/Create", [
            'titulo'      => 'Propuesta',
            'convocatoria' => $proposal->load(['assesstment_criterias', 'documents_supporting']),
            'routeName'      => $this->routeName,
        ]);
        
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
