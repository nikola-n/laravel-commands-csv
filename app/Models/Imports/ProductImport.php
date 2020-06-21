<?php

namespace App\Models\Imports;

use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class ProductImport extends Model
{
    protected $file;

    public $count;

    public $labels;

    public $data;

    public function __construct(string $file)
    {
        parent::__construct();

        $this->file = $file;
        return $this;
    }

    public function convert()
    {
        $keys = array();

        $data        = $this->csvToArray($this->file, ',');
        $this->count = count($data) - 1;

        $this->labels = array_shift($data);

        foreach ($this->labels as $label) {
            $keys[] = $label;
        }
        $keys[] = 'id';

        for ($i = 0; $i < $this->count; $i++) {
            $data[$i][] = $i;
        }
        //for ($j = 0; $j < $this->count; $j++) {
        //    //$d              = array_combine($data[$i][], $data[$j]);
        //    //$this->data[$j] = $d;
        //}
        return $this->data;
    }

    public function csvToArray($file, $delimiter): array
    {
        if (($handle = fopen($file, 'r')) !== false) {
            $i = 0;
            while (($lineArray = fgetcsv($handle, $delimiter, '"')) !== false) {
                for ($j = 0; $j < count($lineArray); $j++) {
                    $arr[$i][$j] = $lineArray[$j];
                }
                $i++;
            }
            fclose($handle);
        }
        return $arr;
    }

    public function createProduct(array $record): Product
    {
        return Product::firstOrCreate([
            'sku' => trim((string)$record['sku']),
        ], [
            'uuid'         => Uuid::uuid4(),
            'name'         => trim($record['name']),
            'slug'         => Str::slug(trim($record['name'])),
            'content'      => trim($record['description']),
            'price'        => (float)$record['price'],
            'stock'        => (int)$record['qty'],
            'manual_stock' => 0,
            'published_at' => now(),
            'import_data'  => $record,
        ]);
    }
}
