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
        // $this->call(UsersTableSeeder::class);

  			factory(App\Models\Product::class, 100)->create();
            factory(App\Models\Category::class, 15)->create();
    }
}
