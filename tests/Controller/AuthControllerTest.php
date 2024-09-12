<?php

namespace App\Tests\Controller;

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private array $authHeader;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->authHeader = [
            'HTTP_AUTHORIZATION' => 'Basic ' . base64_encode('admin:admin'),
            'CONTENT_TYPE' => 'application/json'
        ];
    }

    public function testPostLoginSuccessful()
    {
        $this->client->request('POST', '/api/login', [], [], $this->authHeader, json_encode([
            'email' => 'admin',
            'password' => 'admin'
        ]));

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
    }


    public function testPostLoginError()
    {
        $this->client->request('POST', '/api/login', [], [], $this->authHeader, json_encode([
            'email' => 'user@example.com',
            'password' => 'wrong_password'
        ]));

        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());
    }
}