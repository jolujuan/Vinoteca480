<?php

namespace App\Controller;

use App\Repository\UserRepository;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AuthController extends AbstractController
{

    #[OA\Post(
        path: "/api/login",
        summary: "Login user",
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
                description: "Successful!",
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
    public function login(Request $request, Security $security, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository): Response
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'];
        $password = $data['password'];

        $user = $userRepository->findOneBy(['email' => $email]);

        if ($user && $passwordHasher->isPasswordValid($user, $password)) {
            return $this->json(['status' => 'success', 'user' => $user->getEmail()]);
        }

        return $this->json(['status' => 'error', 'message' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
    }

    #[OA\Post(
        path: "/api/logout",
        description: "Just tests. Deletes the session when cookies are stored in memory (stateless:false)",
        summary: "Logout user",
        tags: ["Authentication"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Successful"
            ),
            new OA\Response(
                response: 401,
                description: "Unauthorized"
            )
        ]
    )]
    #[Route('/api/logout', name: 'app_logout', methods: ['POST'])]

    public function logout(): Response
    {
        return $this->json(['message' => 'see you soon:)']);
    }
}
