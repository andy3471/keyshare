<?php

namespace App\Http\Controllers;

use App\Models\LinkedAccount;
use Illuminate\Http\Request;

class LinkedAccountController extends Controller
{
    // TODO Move from External Login COntroller into here

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LinkedAccount  $linkedAccount
     * @return \Illuminate\Http\Response
     */
    public function show(LinkedAccount $linkedAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LinkedAccount  $linkedAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(LinkedAccount $linkedAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LinkedAccount  $linkedAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LinkedAccount $linkedAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LinkedAccount  $linkedAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(LinkedAccount $linkedAccount)
    {
        //
    }
}
