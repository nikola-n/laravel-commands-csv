<?php

use App\Product;
use App\Tag;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $productIds = Product::pluck('id');
        $tagIds     = Product::pluck('id');

        foreach (range(1, 30) as $index) {
            DB::table('product_tag')->insert([
                'product_id' => $faker->randomElement($productIds),
                'tag_id'     => $faker->randomElement($tagIds),
            ]);
        }
    }
}
