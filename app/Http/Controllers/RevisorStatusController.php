<?php

namespace App\Http\Controllers;

use App\Models\RevisorStatus;
use App\Http\Requests\StoreRevisorStatusRequest;
use App\Http\Requests\UpdateRevisorStatusRequest;

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
    public function store(StoreRevisorStatusRequest $request)
    {
        //
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
