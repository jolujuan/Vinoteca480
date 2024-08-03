<?php

namespace App\Controller;

use App\Repository\MeasuramentRepository;
use App\Repository\WineRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class WineController extends AbstractController
{
    #[Route('api/getWineMeasurament', methods: ["GET"])]
    #[IsGranted('ROLE_USER')]
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


        // return $this->json($wines, 200, [], ['groups' => ['wine_details']]);

    }
}
