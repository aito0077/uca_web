<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

	$this->call('UsersTableSeeder');
        $this->command->info('Users seeded!');

	$this->call('RolesTableSeeder');
        $this->command->info('Roles seeded!');

        // $this->call(UserTableSeeder::class);

        Model::reguard();
    }
}
