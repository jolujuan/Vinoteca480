<?php

namespace App\Controller;

use OpenApi\Attributes as OA;
use App\Entity\Measuraments;
use App\Entity\Sensors;
use App\Entity\Wines;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[OA\Tag('Measuraments')]
class MeasuramentController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[OA\Post(
        path: "/api/addMeasurament",
        description: "Creates a new measurament entry for a specific wine using the provided sensor data.",
        summary: "Add a new measurament",
        requestBody: new OA\RequestBody(
            description: "Measurament data to be added",
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "idSensor", description: "ID of the sensor used", type: "integer", example: 1),
                    new OA\Property(property: "idWine", description: "ID of the wine being measured", type: "integer", example: 3),
                    new OA\Property(property: "year", description: "Year of the measurament", type: "integer", example: 2024),
                    new OA\Property(property: "color", description: "Color of the wine", type: "string", example: "Red"),
                    new OA\Property(property: "temperature", description: "Temperature of the wine", type: "number", format: "float", example: 18.5),
                    new OA\Property(property: "graduation", description: "Alcohol graduation of the wine", type: "number", format: "float", example: 12.5),
                    new OA\Property(property: "ph", description: "pH level of the wine", type: "number", format: "float", example: 3.5),
                ],
                type: "object"
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Measurament created",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "status", type: "string", example: "Measurament created")
                    ]
                )
            ),
            new OA\Response(
                response: 404,
                description: "Sensor or Wine not found",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "error", type: "string", example: "Sensor or Wine not found")
                    ]
                )
            ),
            new OA\Response(
                response: 400,
                description: "Invalid input",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "error", type: "string", example: "Invalid input")
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
