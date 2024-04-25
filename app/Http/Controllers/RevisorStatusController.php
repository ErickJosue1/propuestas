<?php

namespace App\Http\Controllers;

use App\Models\RevisorStatus;
use App\Http\Requests\StoreRevisorStatusRequest;
use App\Http\Requests\UpdateRevisorStatusRequest;
use App\Models\RevisorDocuments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RevisorStatusController extends Controller
{
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
     * @param  \App\Http\Requests\StoreRevisorStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $user = User::find(Auth::user()->id);
        $route = $user->hasRole("Evaluador") ? "revisorDocs.documents" : "proposal.index";

        if ($user->hasRole("Evaluador")) {
            $documentsTotal = RevisorDocuments::whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();

            $documentsUp = RevisorDocuments::whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id);
                $query->where('status', 1);
            })->get();

            if (!($documentsTotal->count() == $documentsUp->count())) {
                return redirect()->route($route)->with('error', 'Faltan Documentos por subir');
            }
        }

        if (RevisorStatus::where("user_id", $user->id)->exists()) {
            RevisorStatus::where("user_id", $user->id)->update(['state_id' => $request->status]);
        } else {
            $user->status()->attach($request->status);
        }


        return redirect()->route($route)->with('success', $request->status .  'Documentos con éxito!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RevisorStatus  $revisorStatus
     * @return \Illuminate\Http\Response
     */
    public function show(RevisorStatus $revisorStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RevisorStatus  $revisorStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(RevisorStatus $revisorStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRevisorStatusRequest  $request
     * @param  \App\Models\RevisorStatus  $revisorStatus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRevisorStatusRequest $request, RevisorStatus $revisorStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RevisorStatus  $revisorStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(RevisorStatus $revisorStatus)
    {
        //
    }
}
