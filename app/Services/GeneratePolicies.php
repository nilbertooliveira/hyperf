<?php

namespace App\Services;

use Donjan\Casbin\Enforcer;

class GeneratePolicies
{

    public function __construct()
    {
        $this->setPolicies();;
    }

    /**
     * @var array|string[]
     */
    private array $path = [
        [
            'path'           => '/users/all',
            'request_method' => 'get',
        ],
        [
            'path'           => '/users/create',
            'request_method' => 'post'
        ],
        [
            'path'           => '/users/update/*',
            'request_method' => 'put'
        ],
        [
            'path'           => '/users/show/*',
            'request_method' => 'get'
        ],
        [
            'path'           => '/users/list-expenses/*',
            'request_method' => 'get'
        ],
        [
            'path'           => '/expenses/create',
            'request_method' => 'post'
        ],
        [
            'path'           => '/expenses/update/*',
            'request_method' => 'put'
        ],
        [
            'path'           => '/expenses/delete',
            'request_method' => 'delete'
        ],
        [
            'path'           => '/expenses/all',
            'request_method' => 'get'
        ],
        [
            'path'           => '/expenses/show/*',
            'request_method' => 'get'
        ],
        [
            'path'           => '/set-policies',
            'request_method' => 'post'
        ],
    ];

    public function setPolicies(): void
    {
        $this->createRolesForUser('nilberto.oliveira@onfly.com.br', 'admin');

        $this->createRolesForUser('readonly@onfly.com.br', 'readonly');

        foreach ($this->path as $item) {
            if ($item['request_method'] === 'get') {
                $this->createPermissionForRoles(
                    'readonly@onfly.com.br',
                    $item['path'],
                    $item['request_method']
                );

                $this->createPermissionForRoles(
                    'nilberto.oliveira@onfly.com.br',
                    $item['path'],
                    $item['request_method']
                );

                continue;
            }
            $this->createPermissionForRoles(
                'nilberto.oliveira@onfly.com.br',
                $item['path'],
                $item['request_method']
            );
        }
    }

    /**
     * @param string $user
     * @param string $role
     * @return bool
     */
    public function createRolesForUser(string $user, string $role): bool
    {
        return Enforcer::addRoleForUser($user, $role);
    }

    /**
     * @param string $user
     * @param string $path
     * @param string $requestMethod
     * @return bool
     */
    public function createPermissionForRoles(string $user, string $path, string $requestMethod): bool
    {
        return Enforcer::addPermissionForUser($user, $path, $requestMethod);
    }


}