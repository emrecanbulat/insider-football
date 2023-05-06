<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\Team;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * @return bool
     */
    public function resetData(): bool
    {
        Fixture::truncate();
        Team::whereNotNull("id")->update(["points" => 0, "win" => 0, "drawn" => 0, "lost" => 0, "goal_dif" => 0, "played" => 0]);

        return true;
    }
}
