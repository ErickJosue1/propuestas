<?php

namespace App\Http\Controllers;

use App\Models\Proposals;
use App\Http\Requests\StoreProposalsRequest;
use App\Http\Requests\UpdateProposalsRequest;
use App\Models\Announcements;
use App\Models\Assestment_Criteria;
use App\Models\Criterias;
use App\Models\Proceedings;
use App\Models\ProposalStates;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $user = Auth::user();
        $records = $user->hasRole('Postulante') ? $records->where('user_id', $user->id)->paginate(4)->withQueryString() : $records->paginate(4)->withQueryString();

        return Inertia::render("Proposals/Index", [
            'titulo'      => 'Tus Propuestas',
            'records'    => $records,
            'routeName'      => $this->routeName,
            'state'      => ProposalStates::all(),
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

        $proposal = $this->model::create($request->validated())->get();

        /*  Proceedings::create([
            'path' => $path,
            'proposal_id' => $proposal->id,
            'user_id'  => $request->user_id
        ]); */

        foreach ($request->myFiles as $files) {
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

        if (Proposals::where('announcement_id', '=', $proposal->id)->exists()) {
            return redirect()->route("announcements.index")->with('success', 'Ya te has postulado para esta convocatoria!');
        } else {
            return Inertia::render("Proposals/Create", [
                'titulo'      => 'Propuesta',
                'convocatoria' => $proposal->load(['assesstment_criterias', 'documents_supporting']),
                'state'        => ProposalStates::find(2),
                'routeName'      => $this->routeName,
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proposals  $proposals
     * @return \Illuminate\Http\Response
     */
    public function edit(Proposals $proposal)
    {

        $records = Announcements::find($proposal->announcement_id);
        $records->load(['assesstment_criterias', 'documents_supporting']);
        $criterias = Criterias::where('proposal_id', '=', "$proposal->id")->get();


        return Inertia::render("Proposals/Edit", [
            'titulo'      => 'Editar Propuesta',
            'proposal'    => $proposal,
            'convocatoria' => $records,
            'state'        => ProposalStates::find(2),
            'routeName'      => $this->routeName,
            'criterias' => $criterias->load(['assesstment_criterias',])
        ]);
    }

    /* 
        Render de review view for the reviewer xd
    */

    public function review(Proposals $proposal)
    {
        $records = Announcements::find($proposal->announcement_id);
        $records->load(['assesstment_criterias', 'documents_supporting']);

        return Inertia::render("Proposals/Review", [
            'titulo'      => 'Revision de propuesta ' . '"' . $proposal->title . '"',
            'proposal'    => $proposal,
            'convocatoria' => $records,
            'routeName'      => $this->routeName,
        ]);
    }


    /* 
        Send the specified Proposal file to the view
    */

    public function downloadPdf($filename, $user)
    {
        $pathToFile = storage_path('app/public/' . User::find($user)->name . 'Expediente/' . $filename);

        return response()->download($pathToFile);
    }

    /* 
        Update the specified resource in storage after setting being reviewed.
     */

    public function updateReview(UpdateProposalsRequest $request, Proposals $proposal)
    {
        $proposal->update($request->validated());

        return redirect()->route("{$this->routeName}index")->with('success', 'Propuesta revisada correctamente!');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProposalsRequest  $request
     * @param  \App\Models\Proposals  $proposals
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProposalsRequest $request, Proposals $proposal)
    {
        $proposal->update($request->validated());

        if (!empty($request->myFiles)) {
            foreach ($request->myFiles as $files) {
                $files->storeAs(Auth::user()->name . 'Expediente', $files->getClientOriginalName(), 'public');
            }
        }

        return redirect()->route("{$this->routeName}index")->with('success', 'Propuesta editada correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proposals  $proposals
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proposals $proposal)
    {
        $proposal->delete();

        return redirect()->route("{$this->routeName}index")->with('success', 'Propuesta eliminada con éxito');
    }
}
