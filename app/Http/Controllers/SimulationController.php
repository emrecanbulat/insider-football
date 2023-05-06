<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use App\Models\Team;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SimulationController extends Controller
{
    const ITERATION_COUNT = 1000;
    const GOAL_PER_MIN_VAL = 0.05;
    const GOAL_PER_MAX_VAL = 0.1;
    const MATCH_LENGTH = 90; // Duration of the match (in minutes)
    private int $remainedPoints;

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $fixtureEnds = Fixture::max("week");
        $currentWeek = Fixture::where("is_played", false)->min("week");
        if ($currentWeek == null) {
            $currentWeek = $fixtureEnds;
        }
        return view("simulator", compact("fixtureEnds", "currentWeek"));
    }

    /**
     * @return bool
     */
    public function resetData(): bool
    {
        try {
            Fixture::truncate();
            Team::whereNotNull("id")->update(["points" => 0, "win" => 0, "drawn" => 0, "lost" => 0, "goal_dif" => 0, "played" => 0, "goal_for" => 0, "goal_against" => 0]);
            return true;
        } catch (Exception $e) {
            logger("an unexpected error has occurred. " . $e->getMessage());
            return false;
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    public function simulate(Request $request): array
    {
        $results = array();
        $fixture = Fixture::select('home_team_id', 'away_team_id')->where("week", $request->week)->where("is_played", false)->get();
        if(is_null($fixture) || $fixture->count() == 0) {
            return $results;
        } else {
            $teams = Team::all();
            foreach ($fixture as $f) {
                $homeTeam = $teams->where("id", $f->home_team_id)->first();
                $awayTeam = $teams->where("id", $f->away_team_id)->first();
                $homeTeamGoal = 0;
                $awayTeamGoal = 0;

                for ($i = 0; $i < self::ITERATION_COUNT; $i++) {
                    // Scoring probabilities for teams
                    $homeTeamGoalProb = $homeTeam->strength / ($homeTeam->strength + $awayTeam->strength);
                    $awayTeamGoalProb = $awayTeam->strength / ($awayTeam->strength + $homeTeam->strength);

                    // probability of goals per minute
                    $goalPerMinute = min(self::GOAL_PER_MIN_VAL, self::GOAL_PER_MAX_VAL / self::MATCH_LENGTH);

                    // Check if there are goals for every minute of the match
                    for ($minute = 1; $minute <= self::MATCH_LENGTH; $minute++) {
                        if (rand(0, 100000) / self::MATCH_LENGTH < $goalPerMinute * $homeTeamGoalProb) {
                            $homeTeamGoal++;
                        }
                        if (rand(0, 100000) / self::MATCH_LENGTH < $goalPerMinute * $awayTeamGoalProb) {
                            $awayTeamGoal++;
                        }
                    }
                }

                // @todo: can be improved, come back later
                $homeTeam->update([
                    "points" => $homeTeamGoal > $awayTeamGoal ? $homeTeam->points + 3 : ($homeTeamGoal == $awayTeamGoal ? $homeTeam->points + 1 : $homeTeam->points),
                    "win" => $homeTeamGoal > $awayTeamGoal ? $homeTeam->win + 1 : $homeTeam->win,
                    "drawn" => $homeTeamGoal == $awayTeamGoal ? $homeTeam->drawn + 1 : $homeTeam->drawn,
                    "lost" => $homeTeamGoal < $awayTeamGoal ? $homeTeam->lost + 1 : $homeTeam->lost,
                    "goal_for" => $homeTeam->goal_for + $homeTeamGoal,
                    "goal_against" => $homeTeam->goal_against + $awayTeamGoal,
                    "goal_dif" => ($homeTeam->goal_for + $homeTeamGoal) - ($homeTeam->goal_against + $awayTeamGoal),
                    "played" => $homeTeam->played + 1,
                ]);

                $awayTeam->update([
                    "points" => $awayTeamGoal > $homeTeamGoal ? $awayTeam->points + 3 : ($awayTeamGoal == $homeTeamGoal ? $awayTeam->points + 1 : $awayTeam->points),
                    "win" => $awayTeamGoal > $homeTeamGoal ? $awayTeam->win + 1 : $awayTeam->win,
                    "drawn" => $awayTeamGoal == $homeTeamGoal ? $awayTeam->drawn + 1 : $awayTeam->drawn,
                    "lost" => $awayTeamGoal < $homeTeamGoal ? $awayTeam->lost + 1 : $awayTeam->lost,
                    "goal_for" => $awayTeam->goal_for + $awayTeamGoal,
                    "goal_against" => $awayTeam->goal_against + $homeTeamGoal,
                    "goal_dif" => ($awayTeam->goal_for + $awayTeamGoal) - ($awayTeam->goal_against + $homeTeamGoal),
                    "played" => $awayTeam->played + 1,
                ]);
                $results[] = [
                    "home_team" => $homeTeam->name,
                    "home_team_goal" => $homeTeamGoal,
                    "away_team" => $awayTeam->name,
                    "away_team_goal" => $awayTeamGoal,
                ];

            }
            Fixture::where("week", $request->week)->update(["is_played" => true]);
            return $results;
        }
    }

    /**
     * @param $team
     * @param $leaderTeamsPoint
     * @param $fixtures
     * @return int|float
     */
    public function calculateTeamChance($team, $leaderTeamsPoint, $fixtures): int|float
    {
        $chance = 0;

        // Can become the champion if wins all the remaining matches? if not, no chance => 0
        if (($this->remainedPoints + $team->points) < $leaderTeamsPoint) {
            return $chance;
        }

        foreach ($fixtures as $fixture) {
//            $awayTeam = Team::where("id", $fixture->away_team_id)->first();
            if ($fixture->home_team_id == $team->id) {
                $chance += 2;
//                $chance += $team->strength / ($team->strength + $awayTeam->strength);;
//                $chance += $team->points;
            }
            $chance += 1;
//            $chance += $awayTeam->strength / ($awayTeam->strength + $team->strength);;
//            $chance += $this->remainedPoints - $team->points;
        }

        // 2* 80 - ((10-6) / 2)

        /*
         *  $homeTeamGoalProb = $homeTeam->strength / ($homeTeam->strength + $awayTeam->strength);
            $awayTeamGoalProb = $awayTeam->strength / ($awayTeam->strength + $homeTeam->strength);
         */

        // @todo: will be checked again
        $chance = $chance * $team->strength - (($leaderTeamsPoint - $team->points) / 2);

        if ($chance > 0) {
            return $chance;
        }
        return 0;
    }

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function getProdiction(): JsonResponse
    {
        $teams = Team::orderBy("points", "desc")->orderBy("goal_dif", "desc")->get();
        $fixtures = Fixture::all();
        $totalWeek = $fixtures->max("week");   //how many weeks will be played in total ?
        $currentWeek = $fixtures->where("is_played", false)->min("week");

        if (is_null($currentWeek)) {    // If $currentWeek is empty, it means the league is over.
            foreach ($teams as $key => $team) {
                if ($key == 0) {
                    $team->chance = 100;
                } else {
                    $team->chance = 0;
                }
            }
        } else {
            $this->remainedPoints = 3 * ($totalWeek - $currentWeek + 1);
            $leaderTeamsPoint = $teams[0]->points;

            foreach ($teams as $team) {
                $team->chance = self::calculateTeamChance($team, $leaderTeamsPoint, $fixtures);
            }

            $totalChance = array_sum(array_column($teams->toArray(), "chance"));
            $inPercent = 100 / $totalChance;

            foreach ($teams as $team) {
                $team->chance = round($team->chance * $inPercent, 2);
            }
        }
        $teams = $teams->sortByDesc("chance");
        return DataTables::of($teams)->toJson();
    }
}
