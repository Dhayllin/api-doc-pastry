<?php

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        DB::table('orders')->insert([
            [
                'id' => 1,
                'customer_id' => 1,
                'product_id' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'id' => 2,
                'customer_id' => 2,
                'product_id' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
