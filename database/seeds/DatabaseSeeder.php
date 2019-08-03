<?php

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        /**
         * Seeding user table
         */
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Model::unguard();

        App\User::truncate();
        factory(App\User::class)->create([
            'name' => 'KCK',
            'email' => 'chrud66@master.com',
            'password' => bcrypt('password'),
            'is_admin' => 1,
        ]);
        factory(App\User::class)->create([
            'name' => 'KCK2',
            'email' => 'chrud666@test.com',
            'password' => bcrypt('password'),
            'is_admin' => 0,
        ]);
        factory(App\User::class)->create([
            'name' => 'KCK2',
            'email' => 'chrud666@test2.com',
            'password' => bcrypt('password'),
            'is_admin' => 0,
        ]);
    }
}
