<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{    
    public function run()
    {
        DB::table('users')->truncate();
        
        factory(\App\User::class, 5)->create();   
        
        $this->createAdmins();    
        
    }

    private function createAdmins()
    {
        User::create([
            'email' => 'teste@teste.com', 
            'name'  => 'Eraldo Teste',
            'password' => bcrypt('senhaum'),
            'address' => 'Address Teste',
            'number' => rand(1, 100),
            'city' => 'City Teste',
            'zip_code' => '87025190',
        ]);
    }

}