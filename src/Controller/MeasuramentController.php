<?php

namespace App\Controller;

use App\Entity\Measuraments;
use App\Entity\Sensors;
use App\Entity\Wines;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class MeasuramentController extends AbstractController
{
    #[Route('api/addMeasurament', methods: ["POST"])]
    #[IsGranted('ROLE_USER')]
    public function addMeasurament(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $sensor = $em->getRepository(Sensors::class)->find($data['idSensor']);
        $wine = $em->getRepository(Wines::class)->find($data['idWine']);

        if (!$sensor || !$wine) {
            return new JsonResponse(['error' => 'Sensor or Wine not found'], 404);
        }

        $measurament = new Measuraments();
        $measurament->setYear($data['year']);
        $measurament->setSensor($sensor);
        $measurament->setWine($wine);
        $measurament->setColor($data['color']);
        $measurament->setTemperature($data['temperature']);
        $measurament->setGraduation($data['graduation']);
        $measurament->setPh($data['ph']);

        $em->persist($measurament);
        $em->flush();

        return new JsonResponse(['status' => 'Measurament created'], 201);
    }
}
