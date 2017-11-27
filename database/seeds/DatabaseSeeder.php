<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Administrador 
        DB::table('admins')->insert([
            'name' => 'Test Admin',
            'email' => 'admin@privanza.com',
            'password' => bcrypt('admin123'),
        ]);

        // Vendedor 
        DB::table('vendedors')->insert([
            'name' => 'Test Vendedor',
            'email' => 'vendedor@privanza.com',
            'password' => bcrypt('vendedor123'),
            'phone' => '55-1943-4641',
            'address' => 'Paseo de Los Tamarindos no.384 Col. Campestre Palo Alto',
        ]);

        // Validador
        DB::table('validadors')->insert([
            'name' => 'Test Validador',
            'email' => 'validador@privanza.com',
            'password' => bcrypt('validador123'),
        ]);

        factory(App\Client::class, 25)->create();
    }
}
