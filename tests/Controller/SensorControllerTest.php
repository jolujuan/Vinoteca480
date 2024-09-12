<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SensorControllerTest extends WebTestCase
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

    public function testListSensorsSuccessful()
    {
        $this->client->request('GET', '/api/sensors', [], [], $this->authHeader);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertJson($this->client->getResponse()->getContent());

        $responseData = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertIsArray($responseData);

        foreach ($responseData as $sensor) {
            $this->assertArrayHasKey('id', $sensor);
            $this->assertArrayHasKey('name', $sensor);
            $this->assertArrayHasKey('user', $sensor);
            $this->assertArrayHasKey('id', $sensor['user']);
            $this->assertArrayHasKey('name', $sensor['user']);
        }
    }

    public function testListSensorsUnauthorized()
    {
        $this->client->request('GET', '/api/sensors', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ]);

        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEmpty($responseData, 'Unauthorized access');
    }

    public function testCreateSensorSuccessful()
    {
        $this->client->request('POST', '/api/sensors', [], [], $this->authHeader, json_encode([
            'idUser' => 1,
            'name' => 'Temperature Sensor'
        ]));

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Registered Sensor', $responseData['status']);
    }

    public function testCreateSensorErrorUserNotFound()
    {
        $this->client->request('POST', '/api/sensors', [], [], $this->authHeader, json_encode([
            'idUser' => 9999999,
            'name' => 'Temperature Sensor'
        ]));

        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('User not found', $responseData['error']);
    }

    public function testCreateSensorInvalidInput()
    {
        $this->client->request('POST', '/api/sensors', [], [], $this->authHeader, json_encode([
            'name' => 'Temperature Sensor'
        ]));

        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Invalid input: Missing fields', $responseData['error']);
    }

    public function testCreateSensorInvalidInputIdUserString()
    {
        $this->client->request('POST', '/api/sensors', [], [], $this->authHeader, json_encode([
            'idUser' => "dsf9999999",
            'name' => 'Temperature Sensor'
        ]));

        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Invalid input: idUser must be numeric', $responseData['error']);
    }
}