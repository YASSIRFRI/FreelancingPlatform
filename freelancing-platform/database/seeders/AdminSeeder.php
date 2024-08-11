<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name'=>"Yassir",
            'email' => 'yassirfri318@gmail.com',
            'password' => Hash::make('Yassirfri123@'),
        ]);
    }
}
