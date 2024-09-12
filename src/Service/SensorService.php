<?php

namespace App\Service;

use App\Entity\Sensors;
use App\Repository\SensorRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SensorService
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;
    private SensorRepository $sensorRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository         $userRepository,
        SensorRepository       $sensorRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->sensorRepository = $sensorRepository;
    }

    public function addSensor(array $sensorData): Sensors
    {
        if (!isset($sensorData['idUser'])||!isset($sensorData['name'])) {
            throw new BadRequestHttpException('Invalid input: Missing fields');
        }

        if (!is_numeric($sensorData['idUser'])) {
            throw new BadRequestHttpException('Invalid input: idUser must be numeric');
        }

        $user = $this->userRepository->find($sensorData['idUser']);
        if (!$user) throw new NotFoundHttpException('User not found');

        $sensor = new Sensors();
        $sensor->setName($sensorData['name']);
        $sensor->setUser($user);

        $this->entityManager->persist($sensor);
        $this->entityManager->flush();

        return $sensor;
    }

    public function fetchSensors(): array
    {
        return $this->sensorRepository->findBy([], ['name' => 'ASC']);
    }
}