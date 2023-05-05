<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => "Manchester City",
                'logo' => 'https://resources.premierleague.com/premierleague/badges/25/t43.png',
                'strength' => rand(10, 100)
            ],
            [
                'name' => "Liverpool",
                'logo' => 'https://resources.premierleague.com/premierleague/badges/25/t14.png',
                'strength' => rand(10, 100)
            ],
            [
                'name' => "Chelsea",
                'logo' => 'https://resources.premierleague.com/premierleague/badges/25/t8.png',
                'strength' => rand(10, 100)
            ],
            [
                'name' => "Arsenal",
                'logo' => 'https://resources.premierleague.com/premierleague/badges/25/t3.png',
                'strength' => rand(10, 100)
            ]
        ];


        DB::table('teams')->insert($data);
    }
}
