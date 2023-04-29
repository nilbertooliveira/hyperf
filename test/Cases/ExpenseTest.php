<?php

namespace Cases;

use HyperfTest\HttpTestCase;

class ExpenseTest extends HttpTestCase
{

    public function testCreate()
    {
        $responseLogin = $this->getLogin();

        $data = [
            'description' => 'Viagem para Roma',
            'price' => 2000.00
        ];

        $response = $this->client->post('/expenses/create', $data, $this->getHeaders($responseLogin));

        $this->assertSame(true, $response['success']);
    }

    public function testAll()
    {
        $responseLogin = $this->getLogin();

        $response = $this->client->get('/expenses/all', [], $this->getHeaders($responseLogin));

        $this->assertSame(true, $response['success']);
    }

}