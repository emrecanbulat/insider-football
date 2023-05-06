<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\Team;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class FixtureController extends Controller
{
    /**
     * @return Application|View|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $teams = Team::all();
        $teamArray = $teams->pluck("id")->shuffle()->toArray();
        $matchCount = 2 * (count($teamArray) - 1);
        $fixtures = array();
        Fixture::truncate();

        for ($i = 0; $i < $matchCount; $i++) {
            $matchList = array();
            for ($j = 0; $j < count($teamArray) / 2; $j++) {
                $homeTeam = $teamArray[$j];
                $awayTeam = $teamArray[count($teamArray) - 1 - $j];

                if ($i % 2 == 0) {
                    $match = array($homeTeam, $awayTeam);
                } else {
                    $match = array($awayTeam, $homeTeam);
                }
                $matchList[] = $match;
            }

            // Changing the position of teams
            array_splice($teamArray, 1, 0, array_pop($teamArray));

            $fixtures[] = $matchList;
            foreach ($matchList as $match) {
                Fixture::create(["home_team_id" => $match[0], "away_team_id" => $match[1], "week" => $i + 1]);
            }
        }
        return view("fixture", compact("fixtures", "teams"));
    }

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function getFixture(): JsonResponse
    {
        $fixtures = Fixture::where("week", Fixture::where("is_played", false)->min("week"))->with('homeTeam', 'awayTeam')->get();
        return DataTables::of($fixtures)->toJson();
    }

}
