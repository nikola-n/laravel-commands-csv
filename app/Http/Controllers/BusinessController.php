<?php

namespace App\Http\Controllers;

use App\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('business.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        //load all data from file
        $file = file($request->file->getRealPath());

        //slice the first row
        $data = array_slice($file, 1);

        //chunk it into different files and save it
        $parts = array_chunk($data, 5000);
        foreach($parts as $index => $part) {
            $fileName = resource_path('pending-files/'.date('Y-m-d').$index.'.csv');
            file_put_contents($fileName, $part);
        }

        (new Business())->importToDb();

        session()->flash('status', 'queued for importing');

        return redirect('import');
    }

}
