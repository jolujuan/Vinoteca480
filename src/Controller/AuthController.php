<?php

namespace App\Controller;

use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{

    #[Route('/api/login', name: 'app_login', methods: ['POST'])]
    #[OA\Post(
        path: "/api/login",
        summary: "Log in a user",
        requestBody: new OA\RequestBody(
            description: "User credentials",
            required: true,
            content: new OA\MediaType(
                mediaType: "application/json",
                schema: new OA\Schema(
                    properties: [
                        new OA\Property(property: "email", type: "string", format: "email", example: "user@example.com"),
                        new OA\Property(property: "password", type: "string", format: "password", example: "password")
                    ],
                    type: "object"
                )
            )
        ),
        tags: ["Authentication"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful login",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(property: "status", type: "string", example: "success"),
                            new OA\Property(property: "user", type: "string", example: "user@example.com")
                        ],
                        type: "object"
                    )
                )
            ),
            new OA\Response(
                response: 401,
                description: "Unauthorized",
                content: new OA\MediaType(
                    mediaType: "application/json",
                    schema: new OA\Schema(
                        properties: [
                            new OA\Property(property: "status", type: "string", example: "error"),
                            new OA\Property(property: "message", type: "string", example: "Invalid credentials")
                        ]
                    )
                )
            )
        ]
    )]
    public function login(Request $request, Security $security): Response
    {
        $user = $security->getUser();
        if ($user) {
            return $this->json(['status' => 'success', 'user' => $user->getUserIdentifier()]);
        }

        return $this->json(['status' => 'error', 'message' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
    }


    public function api(): Response
    {
        return $this->json([
            'user' => $this->getUser() ? $this->getUser()->getUserIdentifier() : null,
            'path' => 'api',
        ]);
    }
}
