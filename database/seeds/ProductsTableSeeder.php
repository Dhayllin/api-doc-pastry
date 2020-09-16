<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        DB::table('products')->insert([
            [
                'id' => 1,
                'name' => 'Pastel de carne',
                'price' =>20,
                'created_at' => $now,
                'updated_at'=> $now,
            ],
            [
                'id' => 2,
                'name' => 'Pastel de queijo',
                'price' =>20,
                'created_at'=> $now,
                'updated_at' => $now,
            ],
            [
                'id' => 3,
                'name' => 'Pastel de palmito',
                'price' => 20,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 4,
                'name' => 'Pastel de frango',
                'price' =>20,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
