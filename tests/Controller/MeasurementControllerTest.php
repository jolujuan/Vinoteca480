<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MeasurementControllerTest extends WebTestCase
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

    public function testCreateMeasurementSuccessful()
    {
        $this->client->request('POST', '/api/measurements', [], [], $this->authHeader, json_encode([
            'idSensor' => 1,
            'idWine' => 3,
            'year' => 2024,
            'color' => 'Red',
            'temperature' => 18.5,
            'graduation' => 12.5,
            'ph' => 3.5
        ]));

        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Measurement created', $responseData['status']);
    }

    public function testCreateMeasurementErrorWineOrSensorNotFound()
    {
        $this->client->request('POST', '/api/measurements', [], [], $this->authHeader, json_encode([
            'idSensor' => 999999,
            'idWine' => 9999999,
            'year' => 2024,
            'color' => 'Red',
            'temperature' => 18.5,
            'graduation' => 12.5,
            'ph' => 3.5
        ]));

        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Sensor or Wine not found', $responseData['error']);
    }

    public function testCreateMeasurementInvalidInput()
    {
        $this->client->request('POST', '/api/measurements', [], [], $this->authHeader, json_encode([
            'idWine' => 3,
            'year' => 2024,
            'color' => 'Red',
            'temperature' => 18.5,
            'graduation' => 12.5,
            'ph' => 3.5
        ]));

        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Invalid input: Missing fields', $responseData['error']);
    }

    public function testCreateMeasurementInvalidInputIdSensorOrIdWineString()
    {
        $this->client->request('POST', '/api/measurements', [], [], $this->authHeader, json_encode([
            'idSensor' => 1,
            'idWine' => "asddas3",
            'year' => 2024,
            'color' => 'Red',
            'temperature' => 18.5,
            'graduation' => 12.5,
            'ph' => 3.5
        ]));

        $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
        $this->assertJson($this->client->getResponse()->getContent());

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEquals('Invalid input: idSensor or idWine must be numeric', $responseData['error']);
    }

    public function testCreateMeasurementUnauthorized()
    {
        $this->client->request('POST', '/api/measurements', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ], json_encode([
            'idSensor' => 1,
            'idWine' => 3,
            'year' => 2024,
            'color' => 'Red',
            'temperature' => 18.5,
            'graduation' => 12.5,
            'ph' => 3.5
        ]));

        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEmpty($responseData, 'Unauthorized access');
    }
}