<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
        [
            'name' => 'admin1',
            'password' => bcrypt('password'),
            'role' => "admin",    
        ],
        [
            'name' => 'User1',
            'password' => bcrypt('password'),
            'role' => "user",    
        ],
        [
            'name' => 'User2',
            'password' => bcrypt('password'),
            'role' => "user",    
        ],
        [
            'name' => 'User3',
            'password' => bcrypt('password'),
            'role' => "user",    
        ],
        [
            'name' => 'User4',
            'password' => bcrypt('password'),
            'role' => "user",    
        ],
        [
            'name' => 'User5',
            'password' => bcrypt('password'),
            'role' => "user",    
        ]],
    );
    }
}
