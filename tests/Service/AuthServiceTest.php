<?php

namespace App\Tests\Service;

use App\Entity\Users;
use App\Repository\UserRepository;
use App\Service\AuthService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthServiceTest extends TestCase
{
    private AuthService $authService;
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;

    protected function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepository::class);
        $this->passwordHasher = $this->createMock(UserPasswordHasherInterface::class);
        $this->authService = new AuthService($this->userRepository, $this->passwordHasher);
    }

    public function testLoginInvalidCredentials()
    {
        $loginDetails = ['email' => 'user@example.com', 'password' => 'wrong_password'];
        $this->userRepository->method('findOneBy')->willReturn(null);

        $this->expectException(UnauthorizedHttpException::class);
        $this->expectExceptionMessage('Invalid credentials');

        $this->authService->login($loginDetails);
    }

    public function testLoginValidCredentials()
    {
        $user = new Users();
        $loginDetails = ['email' => 'admin', 'password' => 'admin'];

        $this->userRepository->method('findOneBy')->willReturn($user);
        $this->passwordHasher->method('isPasswordValid')->willReturn(true);

        $result = $this->authService->login($loginDetails);

        $this->assertSame($user, $result);
    }

    public function testLoginWrongPassword()
    {
        $user = new Users();
        $loginDetails = ['email' => 'user@example.com', 'password' => 'wrong_password'];

        $this->userRepository->method('findOneBy')->willReturn($user);
        $this->passwordHasher->method('isPasswordValid')->willReturn(false);

        $this->expectException(UnauthorizedHttpException::class);
        $this->expectExceptionMessage('Invalid credentials');

        $this->authService->login($loginDetails);
    }
}
