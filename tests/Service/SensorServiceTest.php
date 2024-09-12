<?php

namespace App\Tests\Service;

use App\Entity\Sensors;
use App\Entity\Users;
use App\Repository\SensorRepository;
use App\Repository\UserRepository;
use App\Service\SensorService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SensorServiceTest extends TestCase
{
    private SensorService $sensorService;
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;
    private SensorRepository $sensorRepository;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->sensorRepository = $this->createMock(SensorRepository::class);
        $this->sensorService = new SensorService(
            $this->entityManager,
            $this->userRepository,
            $this->sensorRepository
        );
    }

    public function testAddSensorInvalidInput()
    {
        $this->expectException(BadRequestHttpException::class);
        $this->sensorService->addSensor([]);
    }

    public function testAddSensorInvalidInputIsUserString()
    {
        $this->expectException(BadRequestHttpException::class);
        $this->expectExceptionMessage('Invalid input: idUser must be numeric');
        $this->sensorService->addSensor(['idUser' => "sdfsd999", 'name' => 'Temperature Sensor']);
    }

    public function testAddSensorUserNotFound()
    {
        $this->userRepository->method('find')->willReturn(null);
        $this->expectException(NotFoundHttpException::class);
        $this->sensorService->addSensor(['idUser' => 1, 'name' => 'Temperature Sensor']);
    }

    public function testAddSensorSuccessful()
    {
        $user = new Users();
        $user->setId(1);
        $this->userRepository->method('find')->willReturn($user);
        $sensorData = ['idUser' => 1, 'name' => 'Temperature Sensor'];
        $this->entityManager->expects($this->once())->method('persist');
        $this->entityManager->expects($this->once())->method('flush');

        $result = $this->sensorService->addSensor($sensorData);
        $this->assertInstanceOf(Sensors::class, $result);
        $this->assertEquals('Temperature Sensor', $result->getName());
        $this->assertSame($user, $result->getUser());
    }

    public function testFetchSensors()
    {
        $sensors = [
            (new Sensors())->setName('Sensor 1'),
            (new Sensors())->setName('Sensor 2')
        ];
        $this->sensorRepository->method('findBy')->willReturn($sensors);

        $result = $this->sensorService->fetchSensors();
        $this->assertEquals($sensors, $result);
    }
}