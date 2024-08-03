<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
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
