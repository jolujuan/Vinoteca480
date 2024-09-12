<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WineControllerTest extends WebTestCase
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

    public function testListWinesMeasurementsSuccess()
    {
        $this->client->request('GET', '/api/wines/measurements', [], [], $this->authHeader);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $this->assertJson($this->client->getResponse()->getContent());

        $responseData = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertIsArray($responseData);

        foreach ($responseData as $wine) {
            $this->assertArrayHasKey('id', $wine);
            $this->assertArrayHasKey('name', $wine);
            $this->assertArrayHasKey('year', $wine);
            $this->assertArrayHasKey('measurements', $wine);

            foreach ($wine['measurements'] as $measurement) {
                $this->assertArrayHasKey('id', $measurement);
                $this->assertArrayHasKey('year', $measurement);
                $this->assertArrayHasKey('sensor', $measurement);
                $this->assertArrayHasKey('id', $measurement['sensor']);
                $this->assertArrayHasKey('name', $measurement['sensor']);
                $this->assertArrayHasKey('color', $measurement);
                $this->assertArrayHasKey('temperature', $measurement);
                $this->assertArrayHasKey('graduation', $measurement);
                $this->assertArrayHasKey('ph', $measurement);
            }
        }
    }

    public function testListWinesMeasurementsUnauthorized()
    {
        $this->client->request('GET', '/api/wines/measurements', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ]);

        $this->assertEquals(401, $this->client->getResponse()->getStatusCode());

        $responseData = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertEmpty($responseData, 'Unauthorized access');
    }
}