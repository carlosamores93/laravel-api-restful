<?php

use App\User;
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
        // php artisan db:seed -> para crear los productos
        factory(User::class, 10)->create();
        factory(App\Model\Product::class, 50)->create();
        factory(App\Model\Review::class, 100)->create();
    }
}
