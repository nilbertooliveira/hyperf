<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $user = \App\Model\User::firstOrCreate(
            [
                'name' => 'Nilberto Oliveira',
                'email' => 'nilberto.oliveira@onfly.com.br',
                'password' => '123456'
            ]
        );
    }
}
