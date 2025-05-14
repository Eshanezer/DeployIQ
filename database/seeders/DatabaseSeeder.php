<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RouteSeed::class);
        $this->call(UsertypeSeed::class);
        $this->call(PermissionSeed::class);
        $this->call(UserSeed::class);
    }
}
