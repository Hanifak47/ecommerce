<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminuserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([ // phpcs:ignore PEAR.Functions.FunctionCallSignature.ContentAfterOpenBracket
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin123'),
            'is_admin' => true
        ]);

        User::create([ // phpcs:ignore PEAR.Functions.FunctionCallSignature.ContentAfterOpenBracket
            'name' => 'Hanif Aulia Kusuma',
            'email' => 'hanif@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('1234'),
            'is_admin' => true
        ]);
    }
}
