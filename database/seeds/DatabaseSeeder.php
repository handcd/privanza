<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

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
            'lastname' => 'de Testing',
            'email' => 'vendedor@privanza.com',
            'password' => bcrypt('vendedor123'),
            'phone' => '55-1943-4641',
            'birthday' => Carbon::create('2000','01','01'),
            'address_home' => 'Paseo de Los Tamarindos no.384 Col. Campestre Palo Alto',
            'type' => 1
        ]);

        // Validador
        DB::table('validadors')->insert([
            'name' => 'Test Validador',
            'lastname' => 'de Testing',
            'email' => 'validador@privanza.com',
            'password' => bcrypt('validador123'),
            'job_position' => 'Gerente de Ventas',
            'phone' => '55-3432-2312',
            'birthday'=> Carbon::create('2000','01','01'),
        ]);

        //factory(App\Client::class, 25)->create();
    }
}
