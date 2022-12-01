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
        //ADMIN USERS
        User::create(array(
            'name' => 'admin1',
            'password' => Hash::make('AdminElector****1'),
            'role' => [
                'elector' => false,
                'register' => true,
                'monitor' => true,
                'admin' => true
            ],
            'elector_status' => 'unavaliable',
        ));
        User::create(array(
            'name' => 'admin2',
            'password' => Hash::make('AdminElector****2'),
            'role' => [
                'elector' => false,
                'register' => true,
                'monitor' => true,
                'admin' => true
            ],
            'elector_status' => 'unavaliable',
        ));
        User::create(array(
            'name' => 'admin3',
            'password' => Hash::make('AdminElector****3'),
            'role' => [
                'elector' => false,
                'register' => true,
                'monitor' => true,
                'admin' => true
            ],
            'elector_status' => 'unavaliable',
        ));
        User::create(array(
            'name' => 'admin4',
            'password' => Hash::make('AdminElector****4'),
            'role' => [
                'elector' => false,
                'register' => true,
                'monitor' => true,
                'admin' => true
            ],
            'elector_status' => 'unavaliable',
        ));

        //MONITOR
        User::create(array(
            'name' => 'monitor',
            'password' => Hash::make('MonitorElector****'),
            'role' => [
                'elector' => false,
                'register' => true,
                'monitor' => true,
                'admin' => true
            ],
            'elector_status' => 'unavaliable',
        ));

        //ELECTOR USER
        User::create(array(
            'name' => 'elector1',
            'password' => Hash::make('Elector****1'),
            'role' => [
                'elector' => true,
                'register' => false,
                'monitor' => false,
                'admin' => false
            ],
            'elector_status' => 'unavaliable',
        ));
        User::create(array(
            'name' => 'elector2',
            'password' => Hash::make('Elector****2'),
            'role' => [
                'elector' => true,
                'register' => false,
                'monitor' => false,
                'admin' => false
            ],
            'elector_status' => 'unavaliable',
        ));
        User::create(array(
            'name' => 'elector3',
            'password' => Hash::make('Elector****3'),
            'role' => [
                'elector' => true,
                'register' => false,
                'monitor' => false,
                'admin' => false
            ],
            'elector_status' => 'unavaliable',
        ));
        User::create(array(
            'name' => 'elector4',
            'password' => Hash::make('Elector****4'),
            'role' => [
                'elector' => true,
                'register' => false,
                'monitor' => false,
                'admin' => false
            ],
            'elector_status' => 'unavaliable',
        ));

        //PARTIES
        Party::create(array(
            'party_number' => '1',
            'party_name' => 'name'
        ));

        //SETTINGS
        Settings::create(array(
            'settings_name' => 'election_mode',
            'value' => 'name'
        ));
    }
}
