<?php

namespace Database\Seeders;

use App\Models\Routes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RouteSeed extends Seeder
{
    protected $data = [
        [
            'name' => 'Dashboard',
            'route' => '/home',
            'type' => '1',
        ],
        [
            'name' => 'Logs',
            'route' => '/logs',
            'type' => '1',
        ],
        [
            'name' => 'Histories',
            'route' => '/histories',
            'type' => '1',
        ],
        [
            'name' => 'Permission Management',
            'route' => '/usertypes',
            'type' => '1',
        ],
        [
            'name' => 'User Management',
            'route' => '/users',
            'type' => '1',
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->data as $key => $value) {
            Routes::create($value);
        }
    }
}
