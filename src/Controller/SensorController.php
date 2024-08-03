<?php

namespace App\Controller;

use App\Entity\Sensors;
use App\Entity\Users;
use App\Repository\SensorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SensorController extends AbstractController
{
    #[Route('api/addSensor', methods: ["POST"])]
    #[IsGranted('ROLE_USER')]
    public function addSensors(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = $em->getRepository(Users::class)->find($data['idUser']);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }

        $sensor = new Sensors();
        $sensor->setName($data['name']);
        $sensor->setUser($user);
        $em->persist($sensor);
        $em->flush();

        return new JsonResponse(['status' => 'Registered Sensor'],201);

    }


    #[Route('api/getSensors', methods: ["GET"])]
    #[IsGranted('ROLE_USER')]
    public function getSensors(SensorRepository $sensorRepository): JsonResponse
    {

        $sensors = $sensorRepository->findBy([], ['name' => 'ASC']);
        return $this->json($sensors, 200, [], ['groups' => ['sensor_details']]);
    }

}
