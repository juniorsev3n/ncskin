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

  			factory(App\Models\Frontend\Product::class, 100)->create();
            factory(App\Models\Frontend\Category::class, 15)->create();
    }
}
