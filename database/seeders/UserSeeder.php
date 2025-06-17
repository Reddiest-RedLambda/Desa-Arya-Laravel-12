<?php

namespace Database\Seeders;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => 1,
            'name' => 'Unbara Dark Knight',
            'email' => 'pratamachannel70@gmail.com',
            'password' => 'password',
            'status' => 'approved',
            'role_id' => '1',
        ]);

        User::create([
            'id' => 2,
            'name' => 'Jonkler 1',
            'email' => 'jonkler@gmail.com',
            'password' => 'password',
            'status' => 'approved',
            'role_id' => '2',
        ]);

        Resident::create([
            'user_id' => 2,
            'nik' => '1612156475354657',
            'name' => 'The Jonkler',
            'gender' => 'male',
            'birth_date' => '2000-01-01',
            'birth_place' => 'Gotham City',
            'address' => 'Gotham Street',
            'marital_status' => 'single',
        ]);
    }
}
