<?php

use App\Http\Controllers\FixtureController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});


Route::resource('/', TeamController::class);
Route::resource('fixture', FixtureController::class);
Route::resource('simulation', SimulationController::class);

Route::get('/reset-data', [SimulationController::class, 'resetData'])->name('reset-data');
