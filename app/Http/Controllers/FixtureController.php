<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    /**
     * @return Application|View|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $teams = Team::all();
        $teamArray = Team::pluck("id")->shuffle()->toArray();
        $matchCount = 2 * (count($teamArray) - 1);
        $fixtures = array();

        for ($i = 0; $i < $matchCount; $i++) {
            $matchList = array();
            for ($j = 0; $j < count($teamArray) / 2; $j++) {
                $homeowner = $teamArray[$j];
                $displacement = $teamArray[count($teamArray) - 1 - $j];

                if ($i % 2 == 0) {
                    $match = array($homeowner, $displacement);
                } else {
                    $match = array($displacement, $homeowner);
                }

                $matchList[] = $match;
            }

            // Changing the position of teams
            array_splice($teamArray, 1, 0, array_pop($teamArray));

            $fixtures[] = $matchList;
        }
        return view("fixture", compact("fixtures","teams"));
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
        //
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
}
