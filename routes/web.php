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
    //$arr      = [];
    //$filePath = base_path('public/annual-enterprise-survey-2018-financial-year-provisional-csv.csv');
    //if (($h = fopen($filePath, 'r+')) !== false) {
    //    while (! feof($h)) {
    //        $data = fgetcsv($h);
    //        $arr[] = $data;
    //        Business::updateOrCreate([
    //            'year'                        => $arr[1],
    //            'Industry_aggregation_NZSIOC' => $arr[2],
    //            'Industry_code_NZSIOC'        => $arr[3],
    //            'Industry_name_NZSIOC'        => $arr[4],
    //            'Units'                       => $arr[5],
    //            'Variable_code'               => $arr[6],
    //            'Variable_name'               => $arr[7],
    //            'Variable_category'           => $arr[8],
    //            'Value'                       => $arr[9],
    //            'Industry_code_ANZSIC06'      => $arr[10],
    //        ]);
    //    }
    //    fclose($h);
    //}
    return view('welcome');
});
Route::get('import', 'BusinessController@create')->name('business.create');
Route::post('import', 'BusinessController@store')->name('business.store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/leagues', 'FootballController@index');


Route::get('news', \NewsController::class);

Route::get('github', \GitHubController::class);


Route::resource('products', \ProductController::class);
