<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OAuthClientsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'id' => 'appid1',
            'secret' => 'secret',
            'name' => 'APPAngular',
        ]);
    }
}
