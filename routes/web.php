<?php

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\User;
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

Route::get('/resource', function () {
    //eager loaded it to avoid N+1 query problem
    //$user = User::with('roles')->find(1);
    //return new UserResource($user);

    //if we have collection
    $user = User::with('roles')->paginate(1);
    //return new UserResource($user);
    return UserResource::collection($user);
});

//If you paginate the results you can't change the 'data' key even if you
//call withoutWrapping method in the AppServiceProvider
//Paginated responses always contain meta and links keys with information about the paginator's state
Route::get('/collection', function () {

    $user = User::with('roles')->paginate(1);

    return new UserCollection($user);
});


Route::get('import', 'BusinessController@create')->name('business.create');
Route::post('import', 'BusinessController@store')->name('business.store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/leagues', 'FootballController@index');

Route::get('news', \NewsController::class);

Route::get('github', \GitHubController::class);
