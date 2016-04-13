<?php

use CodeProject\Entities\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(User::class)->create([
            'name' => 'marcelo',
            'email' => 'eng.msilva@yahoo.com.br',
            'password' => bcrypt(123456),
            'remember_token' => str_random(10),
        ]);

        factory(User::class,10)->create();
    }
}
