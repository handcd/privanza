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
        factory(App\Vendedor::class)->create([
            'email' => 'vendedor@privanza.com'
        ]);

        // Validador
        factory(App\Validador::class)->create([
            'email' => 'validador@privanza.com'
        ]);

        // Fits
        DB::table('fits')->insert([
            'name' => 'Tallas Extra',
            'description' => 'Medidas para personas con busto amplio.'
        ]);
        DB::table('fits')->insert([
            'name' => 'Normal',
            'description' => 'Medidas de talla normal.'
        ]);
        DB::table('fits')->insert([
            'name' => 'Privanza',
            'description' => 'Fit más entallado.'
        ]);

        factory(App\Vendedor::class, 40)->create();
        factory(App\Client::class, App\Vendedor::all()->count()*15)->create();
        factory(App\Event::class, 600)->create();
        factory(App\Validador::class, 10)->create();
    }
}
