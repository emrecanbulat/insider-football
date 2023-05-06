<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixture extends Model
{
    use HasFactory;

    protected $fillable = ["home_team_id", "away_team_id", "week", "is_played"];

    public function homeTeam()
    {
        return $this->hasMany(Team::class, 'id', 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->hasMany(Team::class, 'id', 'away_team_id');
    }
}
