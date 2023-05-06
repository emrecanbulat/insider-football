<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Yajra\DataTables\DataTables;

class TeamController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function index(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $teams = Team::all();
        return view("teams", compact("teams"));
    }

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function getTeams(): JsonResponse
    {
        $teams = Team::OrderBy("points", "desc")->OrderBy("goal_dif", "desc")->get();
        return DataTables::of($teams)->toJson();
    }

}
