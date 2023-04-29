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
                'email' => \Hyperf\Support\env('USER_EMAIL'),
            ],
            [
                'name'     => \Hyperf\Support\env('USER_NAME'),
                'email'    => \Hyperf\Support\env('USER_EMAIL'),
                'password' => password_hash(\Hyperf\Support\env('USER_PASSWORD'), PASSWORD_BCRYPT),
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
