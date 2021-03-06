<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Tyson London',
            'email' => 'tyson@modcul.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin'
        ]);

        factory(User::class, 250)->create();
    }
}
