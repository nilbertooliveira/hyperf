<?php

namespace Cases;

use HyperfTest\HttpTestCase;

class UserTest extends HttpTestCase
{
    public function testLogin()
    {
        $response = $this->getLogin();

        $this->assertSame(true, $response['success']);

        return $response;
    }

    public function testLogout()
    {
        $responseLogin = $this->getLogin();

        $response = $this->client->json('/users/logout', [], $this->getHeaders($responseLogin));

        $this->assertSame(true, $response['success']);
    }

    public function testAll()
    {
        $responseLogin = $this->getLogin();

        $response = $this->client->get('/users/all', [], $this->getHeaders($responseLogin));

        $this->assertSame(true, $response['success']);
    }
}