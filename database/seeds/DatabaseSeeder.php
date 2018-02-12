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
        factory(App\Client::class, 30)->create([
            'vendedor_id' => 1,
        ]);
        factory(App\Client::class, App\Vendedor::all()->count()*15)->create();
        factory(App\Event::class, 600)->create();
        factory(App\Validador::class, 10)->create();

        // Generate 10 orders for the main Vendedor
        for ($i=1; $i <= 10; $i++) { 
            $orden = factory(App\Order::class)->create([
                'vendedor_id' => 1,
            ]);
            if ($orden->vest) {
                factory(App\Vest::class)->create([
                    'order_id' => $i,
                ]);
            }
            if ($orden->coat) {
                factory(App\Coat::class)->create([
                    'order_id' => $i,
                ]);
            }
            if ($orden->pants) {
                factory(App\Pants::class)->create([
                    'order_id' => $i,
                ]);
            }

        }

        // Generate 100 random orders
        for ($i=11; $i <= 110; $i++) { 
            $orden = factory(App\Order::class)->create();
            if ($orden->vest) {
                factory(App\Vest::class)->create([
                    'order_id' => $i,
                ]);
            }
            if ($orden->coat) {
                factory(App\Coat::class)->create([
                    'order_id' => $i,
                ]);
            }
            if ($orden->pants) {
                factory(App\Pants::class)->create([
                    'order_id' => $i,
                ]);
            }

        }
    }
}
