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
            'name' => 'Veronica López',
            'email' => 'velopez@isco.com.mx',
            'password' => bcrypt('vlopez123'),
        ]);
        
        // Vendedores
        //Nancy
        factory(App\Vendedor::class)->create([
            'name' => 'Nancy',
            'email' => 'nancy@isco.com.mx',
            'password' => bcrypt('nancyisco123'),
        ]);
        //Erick
        factory(App\Vendedor::class)->create([
            'name' => 'Erick Rodríguez',
            'email' => 'erick.ro@gmail.com',
            'password' => bcrypt('erickisco123'),
        ]);
        //Laureano
        factory(App\Vendedor::class)->create([
            'name' => 'Laureano Fernandez',
            'email' => 'laureano.fdz@isco.com.mx',
            'password' => bcrypt('laureanoisco123'),
        ]);
        //Admon
        factory(App\Vendedor::class)->create([
            'name' => 'Alejandro',
            'email' => 'admon@casaartoria.com',
            'password' => bcrypt('admonisco123'),
        ]);
        //Alejandra Encinas
        factory(App\Vendedor::class)->create([
            'name' => 'Alejandra Encinas',
            'email' => 'alejandra.encinas@isco.com.mx',
            'password' => bcrypt('alejandraisco123'),
        ]);

        // Validador
        factory(App\Validador::class)->create([
            'name' => 'Yuliana Ramírez',
            'email' => 'yramirez@isco.com.mx',
            'password' => bcrypt('yramirez123'),
        ]);

        // Database
        DB::table('configurations')->insert([
            'horas_aviso_no_aprobada' => 4
        ]);

        // Fits
        DB::table('fits')->insert([
            'name' => 'Tallas Extra',
            'description' => 'Medidas para personas robustas.'
        ]);
        DB::table('fits')->insert([
            'name' => 'Clásico',
            'description' => 'Medidas de talla normal.'
        ]);
        DB::table('fits')->insert([
            'name' => 'Privanza',
            'description' => 'Medidas para personas menudas.'
        ]);
        
        /*factory(App\Vendedor::class, 10)->create();
        factory(App\Client::class, 10)->create([
            'vendedor_id' => 1,
        ]);*/
        /*factory(App\Client::class, App\Vendedor::all()->count()*2)->create();
        /*factory(App\Event::class, 10)->create();
        factory(App\Validador::class, 10)->create();*/

        //Generate 10 orders for the main Vendedor
        /*for ($i=1; $i <= 20; $i++) { 
            $orden = factory(App\Order::class)->create([
                'vendedor_id' => 1,
                'client_id' => App\Vendedor::find(1)->clients->random(),
            ]);
            if ($orden->has_vest) {
                factory(App\Vest::class)->create([
                    'order_id' => $i,
                ]);
            }
            if ($orden->has_coat) {
                factory(App\Coat::class)->create([
                    'order_id' => $i,
                ]);
            }
            if ($orden->has_pants) {
                factory(App\Pants::class)->create([
                    'order_id' => $i,
                ]);
            }

        }*/

        // Generate 100 random orders
        /*for ($i=1; $i <= 11; $i++) { 
            $orden = factory(App\Order::class)->create();
            if ($orden->has_vest) {
                factory(App\Vest::class)->create([
                    'order_id' => $i,
                ]);
            }
            if ($orden->has_coat) {
                factory(App\Coat::class)->create([
                    'order_id' => $i,
                ]);
            }
            if ($orden->has_pants) {
                factory(App\Pants::class)->create([
                    'order_id' => $i,
                ]);
            }

        }*/

        /*factory(App\AdjustmentOrder::class,10)->create();
        factory(App\Adjustment::class,10)->create();*/
    }
}
