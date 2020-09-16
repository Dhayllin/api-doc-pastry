<?php

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        DB::table('customers')->insert([
            [
                'id' => 1,
                'name' => 'Luiza Isis Souza',
                'email' => 'lluizaisissouza@4now.com.br',
                'telephone' => '113611-5922',
                'date_birth' => '1973-09-23',
                'cep' => '05415-001',
                'address' => 'Rua Joaquim Antunes',
                'neighborhood' => 'Pinheiros',
                'created_at' => $now,
                'updated_at'=> $now,
                'deleted_at'=> null
            ],
            [
                'id' => 2,
                'name' => 'Lucca Oliver Moreira',
                'email' => 'luccaolivermoreira_@oana.com.br',
                'telephone' => '113658-5491',
                'date_birth' => '1981-08-22',
                'cep' => '04933-120',
                'address' => 'Rua dos Violoncelos',
                'neighborhood' => 'Jardim Santa Zélia',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at'=> null
            ],
            [
                'id' => 3,
                'name' => 'Leonardo Raul Severino Assunção',
                'telephone' => '113503-5897',
                'email' => 'leonardoraulse@atualmarcenaria.com.br',
                'date_birth' => '1998-12-11',
                'cep' => '04455-150',
                'address' => 'Rua Paulo Adanísio',
                'neighborhood' => 'Vila Campo Grande',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at'=>'2020-09-16 00:54:53.000000'
            ],
            [
                'id' => 4,
                'name' => 'Bianca Aurora Lívia Rezende',
                'telephone' => '113963-8820',
                'email' => 'biancaauroraliviarezende@l3ambiental.com.br',
                'date_birth' => '1991-06-09',
                'cep' => '02964-100',
                'address' => 'Rua Francisco Antônio Iório',
                'neighborhood' => 'Vila Iório',
                'created_at' => $now,
                'updated_at' => $now,
                'deleted_at'=> null
            ],
        ]);
    }
}
