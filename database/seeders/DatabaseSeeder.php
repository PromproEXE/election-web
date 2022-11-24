<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Party;
use App\Models\Settings;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create(array(
            'name' => 'ADMIN',
            'password' => Hash::make('12345678'),
            'role' => [
                'elector' => false,
                'register' => true,
                'monitor' => true,
                'admin' => true
            ],
            'elector_status' => 'unavaliable',
        ));
        User::create(array(
            'name' => 'ELECTOR_1',
            'password' => Hash::make('12345678'),
            'role' => [
                'elector' => true,
                'register' => false,
                'monitor' => false,
                'admin' => false
            ],
            'elector_status' => 'unavaliable',
        ));
        User::create(array(
            'name' => 'ELECTOR_2',
            'password' => Hash::make('12345678'),
            'role' => [
                'elector' => true,
                'register' => false,
                'monitor' => false,
                'admin' => false
            ],
            'elector_status' => 'unavaliable',
        ));
        Settings::create(array(
            'settings_name' => 'election_mode',
            'value' => 'number_only'
        ));
    }
}
