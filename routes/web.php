<?php

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Jobs\ProcessCsvUpload;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::get('news', NewsController::class);

Route::get('github', GitHubController::class);

//Job workflows
//- chain
//- batch
Route::get('/chainingJobs', function () {

    $chain = [
        new ProcessCsvUpload('public'),
        new AnotherJob,
        new AnotherOne,
    ];

    Bus::dispatchChain($chain);
});

Route::get('/batchingJobs', function () {

    $batch = [
        new ProcessCsvUpload('public/project.csv'),
        new ProcessCsvUpload('public/project1.csv'),
        new ProcessCsvUpload('public/project2.csv'),
    ];

    Bus::batch($batch)
        //not to mark this batch as canceled
        ->allowFailures()
        ->catch(function ($batch, $e) {
            //
        })
        ->then(function ($batch) {

        })
        ->finally(function ($batch) {

        })
        ->onQueue('deployments')
        ->onConnection('database')
        ->dispatch();
});

//invoke a chain inside a batch
Route::get('/chainInsideBatch', function () {
    $batch = [
        [
            new ProcessCsvUpload('public/project1.csv'),
            new RunTests('public/project1.csv'),
            new Deploy('public/project1.csv'),
        ],
        [
            new ProcessCsvUpload('public/project2.csv'),
            new RunTests('public/project2.csv'),
            new Deploy('public/project2.csv'),
        ],
    ];
    Bus::batch($batch);
});

Route::get('/batchInsideChain', function () {

    Bus::chain([
        new ProcessCsvUpload('dsaasdsda'),
        function () {
            Bus::batch([
                new newJob(),
                new newJobA(),
                new newJobB(),
            ])->dispatch();
        },
    ])->dispatch();
});

Route::post('/markdown', function () {
    return Str::of(request('markdown'))->markdown();
});
