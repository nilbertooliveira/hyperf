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
        \App\Model\User::firstOrCreate(
            [
                'email' => 'nilberto.oliveira@onfly.com.br',
            ],
            [
                'name'     => 'Nilberto Oliveira',
                'email'    => 'nilberto.oliveira@onfly.com.br',
                'password' => password_hash('123456', PASSWORD_BCRYPT),
            ]
        );

        \App\Model\User::firstOrCreate(
            [
                'email' => 'readonly@onfly.com.br',
            ],
            [
                'name'     => 'Readonly',
                'email'    => 'readonly@onfly.com.br',
                'password' => password_hash('123456', PASSWORD_BCRYPT),
            ]
        );
    }
}
