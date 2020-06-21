<?php

namespace App\Jobs;

use App\Business;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class ProcessCsvUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $file;

    /**
     * Create a new job instance.
     *
     * @param string $file
     */
    public function __construct(string $file)
    {

        $this->file = $file;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Redis::throttle('upload-csv')->block(0)->allow(1)->every(5)->then(function () {
            info('Lock obtained...');
            dump('processing this file: ---'. $this->file);
            $data = array_map('str_getcsv', file($this->file));
            foreach ($data as $row) {
                Business::updateOrCreate([
                    'year'                        => $row[0],
                    'Industry_aggregation_NZSIOC' => $row[1],
                    'Industry_code_NZSIOC'        => $row[2],
                    'Industry_name_NZSIOC'        => $row[3],
                    'Units'                       => $row[4],
                    'Variable_code'               => $row[5],
                    'Variable_name'               => $row[6],
                    'Variable_category'           => $row[7],
                    'Value'                       => $row[8],
                    'Industry_code_ANZSIC06'      => $row[9],
                ]);
                dump('done this file: ---'. $this->file);

            }
            //delete the file and go on to the other file
            unlink($this->file);
        }, function () {
            // Could not obtain lock...

            return $this->release(5);
        });

    }
}
