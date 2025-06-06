<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    protected $data = [
        [
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => 'Admin@123',
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data as $key => $value) {
            $value['usertype'] = $key + 1;
            $value['password'] = Hash::make($value['password']);
            User::create($value);
        }
    }
}
