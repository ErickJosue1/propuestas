<?php

namespace App\Http\Controllers;

use App\Models\announcement_field;
use App\Http\Requests\Storeannouncement_fieldRequest;
use App\Http\Requests\Updateannouncement_fieldRequest;

class AnnouncementFieldController extends Controller
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
     * @param  \App\Http\Requests\Storeannouncement_fieldRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Storeannouncement_fieldRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\announcement_field  $announcement_field
     * @return \Illuminate\Http\Response
     */
    public function show(announcement_field $announcement_field)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\announcement_field  $announcement_field
     * @return \Illuminate\Http\Response
     */
    public function edit(announcement_field $announcement_field)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updateannouncement_fieldRequest  $request
     * @param  \App\Models\announcement_field  $announcement_field
     * @return \Illuminate\Http\Response
     */
    public function update(Updateannouncement_fieldRequest $request, announcement_field $announcement_field)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\announcement_field  $announcement_field
     * @return \Illuminate\Http\Response
     */
    public function destroy(announcement_field $announcement_field)
    {
        //
    }
}
