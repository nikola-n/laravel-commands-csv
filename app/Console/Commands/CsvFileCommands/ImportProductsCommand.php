<?php

namespace App\Console\Commands\CsvFileCommands;

use App\Models\Imports\ProductImport;
use Illuminate\Console\Command;

class ImportProductsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports data from csv file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $productImport = new ProductImport(base_path('database/data/catalog_product_20200103_130408.csv'));
        //$productImport->csvToArray($productImport, 400);
        //$productImport->convert();
        foreach ($productImport->convert() as $record) {
            $productImport->createProduct($record);
        }
    }
}
