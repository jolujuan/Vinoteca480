<?php

namespace App\Tests\Service;

use App\Entity\Measurements;
use App\Entity\Sensors;
use App\Entity\Wines;
use App\Repository\SensorRepository;
use App\Repository\WineRepository;
use App\Service\MeasurementService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MeasurementServiceTest extends TestCase
{
    private MeasurementService $measurementService;
    private EntityManagerInterface $entityManager;
    private SensorRepository $sensorRepository;
    private WineRepository $wineRepository;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->sensorRepository = $this->createMock(SensorRepository::class);
        $this->wineRepository = $this->createMock(WineRepository::class);
        $this->measurementService = new MeasurementService(
            $this->entityManager,
            $this->sensorRepository,
            $this->wineRepository
        );
    }

    public function testAddMeasurementInvalidInput()
    {
        $this->expectException(BadRequestHttpException::class);
        $this->measurementService->addMeasurement([]);
    }

    public function testAddMeasurementInvalidInputIdSensorOrIdWineString()
    {
        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage('Invalid input: idSensor or idWine must be numeric');
        $this->measurementService->addMeasurement(['idSensor' => 'dsjhdsf21', 'idWine' => 3]);
    }

    public function testAddMeasurementNotFound()
    {
        $this->sensorRepository->method('find')->willReturn(null);
        $this->wineRepository->method('find')->willReturn(null);
        $this->expectException(NotFoundHttpException::class);
        $this->measurementService->addMeasurement(['idSensor' => 1, 'idWine' => 1]);
    }

    public function testAddMeasurementSuccessful()
    {
        $sensor = new Sensors();
        $measurements = new ArrayCollection();
        $wine = new Wines($measurements);

        $this->sensorRepository->method('find')->willReturn($sensor);
        $this->wineRepository->method('find')->willReturn($wine);

        $measurementData = [
            'idSensor' => 1,
            'idWine' => 1,
            'year' => 2021,
            'color' => 'Red',
            'temperature' => 22.5,
            'graduation' => 13.0,
            'ph' => 3.6
        ];

        $this->entityManager->expects($this->once())->method('persist');
        $this->entityManager->expects($this->once())->method('flush');

        $result = $this->measurementService->addMeasurement($measurementData);

        $this->assertInstanceOf(Measurements::class, $result);
        $this->assertEquals($sensor, $result->getSensor());
        $this->assertEquals($wine, $result->getWine());
        $this->assertEquals(2021, $result->getYear());
        $this->assertEquals('Red', $result->getColor());
        $this->assertEquals(22.5, $result->getTemperature());
        $this->assertEquals(13.0, $result->getGraduation());
        $this->assertEquals(3.6, $result->getPh());
    }
}