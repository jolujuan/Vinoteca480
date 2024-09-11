<?php

namespace App\Service;

use App\Entity\Measurements;
use App\Repository\SensorRepository;
use App\Repository\WineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MeasurementService
{
    private EntityManagerInterface $entityManager;
    private SensorRepository $sensorRepository;
    private WineRepository $wineRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        SensorRepository       $sensorRepository,
        WineRepository         $wineRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->sensorRepository = $sensorRepository;
        $this->wineRepository = $wineRepository;
    }

    public function addMeasurement(array $measurementData): Measurements
    {
        $sensor = $this->sensorRepository->find($measurementData['idSensor']);
        $wine = $this->wineRepository->find($measurementData['idWine']);

        if (!$sensor || !$wine) {
            throw  new NotFoundHttpException('Sensor or Wine not found');
        }

        $measurement = new Measurements();
        $measurement->setYear($measurementData['year']);
        $measurement->setSensor($sensor);
        $measurement->setWine($wine);
        $measurement->setColor($measurementData['color']);
        $measurement->setTemperature($measurementData['temperature']);
        $measurement->setGraduation($measurementData['graduation']);
        $measurement->setPh($measurementData['ph']);

        $this->entityManager->persist($measurement);
        $this->entityManager->flush();

        return $measurement;
    }
}