<?php

namespace App\Controller;

use OpenApi\Attributes as OA;
use App\Entity\Sensors;
use App\Entity\Users;
use App\Repository\SensorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[OA\Tag('Sensors')]
class SensorController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[OA\Post(
        path: "/api/addSensor",
        description: "Registers a new sensor and associates it with a user.",
        summary: "Add a new sensor",
        requestBody: new OA\RequestBody(
            description: "Sensor data to be added",
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "idUser", description: "ID of the user to associate the sensor with", type: "integer", example: 1),
                    new OA\Property(property: "name", description: "Name of the sensor", type: "string", example: "Temperature Sensor"),
                ],
                type: "object"
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Sensor registered successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "string", example: "Registered Sensor")
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "User not found",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "error", type: "string", example: "User not found")
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: "Invalid input",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "error", type: "string", example: "Invalid input data")
                    ]
                )
            ),
            new OA\Response(
                response: 401,
                description: "Unauthorized access",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "string", example: "error"),
                        new OA\Property(property: "message", type: "string", example: "Unauthorized access"),
                    ]
                )
            ),
            new OA\Response(
                response: 403,
                description: "Forbidden",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "string", example: "error"),
                        new OA\Property(property: "message", type: "string", example: "Forbidden"),
                    ]
                )
            ),
        ]
    )]
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

    #[IsGranted('ROLE_USER')]
    #[OA\Get(
        path: "/api/getSensors",
        description: "Retrieves a list of all sensors sorted by name in ascending order.",
        summary: "Get all sensors",
        responses: [
            new OA\Response(
                response: 200,
                description: "List of sensors retrieved successfully",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: "id", type: "integer", example: 1),
                            new OA\Property(property: "name", type: "string", example: "Temperature Sensor"),
                            new OA\Property(property: "user", properties: [
                                new OA\Property(property: "id", type: "integer", example: 1),
                                new OA\Property(property: "name", type: "string", example: "John Doe"),
                            ],
                                type: "object"
                            ),
                        ],
                        type: "object"
                    )
                )
            ),
            new OA\Response(
                response: 401,
                description: "Unauthorized access",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "string", example: "error"),
                        new OA\Property(property: "message", type: "string", example: "Unauthorized access"),
                    ]
                )
            ),
            new OA\Response(
                response: 403,
                description: "Forbidden",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "error", type: "string", example: "Forbidden")
                    ]
                )
            )
        ]
    )]
    public function getSensors(SensorRepository $sensorRepository): JsonResponse
    {

        $sensors = $sensorRepository->findBy([], ['name' => 'ASC']);
        return $this->json($sensors, 200, [], ['groups' => ['sensor_details']]);
    }

}
