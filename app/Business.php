<?php

namespace App;

use App\Jobs\ProcessCsvUpload;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $guarded = [];

    public function importToDb()
    {

        //get the path of the csv files
        $path = resource_path('pending-files/*.csv');
        //this will get array of all files like [ 0 => pathOfFirstFile, 1 => pathOfSecondFile] etc..
        $g = glob($path);
        //here we limit the execution files to 2
        //foreach (array_slice($g, 0, 2) as $file) {

        //if we use redis we dont need to limit
        foreach ($g as $file) {
            //add all the logic in job to queue it and
            //execute until it gets all data
            ProcessCsvUpload::dispatch($file);
        }
    }
}
