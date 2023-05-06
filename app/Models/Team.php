<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ["points", "name", "logo", "played", "win", "drawn", "lost", "goal_dif", "goal_for", "goal_against"];
}
