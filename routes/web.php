<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
extension_loaded('redis');

Route::get('/', function () {
    return view('welcome');
});
Route::get('import', 'BusinessController@create')->name('business.create');
Route::post('import', 'BusinessController@store')->name('business.store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/leagues', 'FootballController@index');

Route::get('news', \NewsController::class);

Route::get('github', \GitHubController::class);
