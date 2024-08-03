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
        $vino = $em->getRepository(Wines::class)->find($data['idVino']);

        if (!$sensor || !$vino) {
            return new JsonResponse(['error' => 'Sensor or Wine not found'], 404);
        }

        $measurament = new Measuraments();
        $measurament->setAño($data['año']);
        $measurament->setSensor($sensor);
        $measurament->setVino($vino);
        $measurament->setColor($data['color']);
        $measurament->setTemperatura($data['temperatura']);
        $measurament->setGraduacion($data['graduacion']);
        $measurament->setPh($data['ph']);

        $em->persist($measurament);
        $em->flush();

        return new JsonResponse(['status' => 'Measurament created'], 201);
    }
}
