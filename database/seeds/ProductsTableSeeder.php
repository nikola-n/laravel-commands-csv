<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 30) as $index) {
            \DB::table('products')->insert([
                'title'        => $faker->sentence(5),
                'body'         => $faker->text,
                'some-boolean' => $faker->boolean,
            ]);
        }
    }
}
