<?php

namespace App\Http\Controllers;

use App\Models\proposal_field;
use App\Http\Requests\Storeproposal_fieldRequest;
use App\Http\Requests\Updateproposal_fieldRequest;

class ProposalFieldController extends Controller
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
     * @param  \App\Http\Requests\Storeproposal_fieldRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storeproposal_fieldRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\proposal_field  $proposal_field
     * @return \Illuminate\Http\Response
     */
    public function show(proposal_field $proposal_field)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\proposal_field  $proposal_field
     * @return \Illuminate\Http\Response
     */
    public function edit(proposal_field $proposal_field)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updateproposal_fieldRequest  $request
     * @param  \App\Models\proposal_field  $proposal_field
     * @return \Illuminate\Http\Response
     */
    public function update(Updateproposal_fieldRequest $request, proposal_field $proposal_field)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\proposal_field  $proposal_field
     * @return \Illuminate\Http\Response
     */
    public function destroy(proposal_field $proposal_field)
    {
        //
    }
}
