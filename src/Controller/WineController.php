<?php

namespace App\Controller;

use OpenApi\Attributes as OA;
use App\Repository\MeasuramentRepository;
use App\Repository\WineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[OA\Tag('Wines')]
class WineController extends AbstractController
{
    #[Route('api/getWineMeasurament', methods: ["GET"])]
    #[OA\Get(
        path: "/api/getWineMeasurament",
        description: "Returns a list of all wine measurements available in the database.",
        summary: "Gets all wine measurements",
        security: [["basicAuth" => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Wine measurement list successfully obtained",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(
                        properties: [
                            new OA\Property(property: "id", type: "integer", example: 1),
                            new OA\Property(property: "name", type: "string", example: "Chardonnay"),
                            new OA\Property(property: "year", type: "integer", example: 2020),
                            new OA\Property(
                                property: "measuraments",
                                type: "array",
                                items: new OA\Items(
                                    properties: [
                                        new OA\Property(property: "id", type: "integer", example: 1),
                                        new OA\Property(property: "year", type: "integer", example: 2020),
                                        new OA\Property(property: "sensor", properties: [
                                            new OA\Property(property: "id", type: "integer", example: 1),
                                            new OA\Property(property: "name", type: "string", example: "Temperature Sensor"),
                                        ],
                                            type: "object"
                                        ),
                                        new OA\Property(property: "color", type: "string", example: "Red"),
                                        new OA\Property(property: "temperature", type: "number", format: "float", example: 18.5),
                                        new OA\Property(property: "graduation", type: "number", format: "float", example: 12.5),
                                        new OA\Property(property: "ph", type: "number", format: "float", example: 3.5),
                                    ],
                                    type: "object"
                                )
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
                        new OA\Property(property: "status", type: "string", example: "error"),
                        new OA\Property(property: "message", type: "string", example: "Forbidden"),
                    ]
                )
            ),
        ]
    )]
    public function getWineMeasurament(WineRepository $wineRepository, MeasuramentRepository $measuramentRepository, SerializerInterface $serializer): JsonResponse
    {
        $wines = $wineRepository->findAll();

        $context = [
            'groups' => ['wine_details'],
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];

        $jsonContent = $serializer->serialize($wines, 'json', $context);

        return new JsonResponse($jsonContent, 200, [], true);
    }
}
