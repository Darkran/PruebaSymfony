<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{

    #[Route('/register', name: 'app_register')]
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }


    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function register(Request $request): JsonResponse
    {
        $content = $request->getContent();
        $data = json_decode($content, true);
        $username = $data['username'];
        $password = $data['password'];
        if (empty($username)) {
            return new JsonResponse(['success' => false, 'message' => 'Campo de usuario vacio.'], JsonResponse::HTTP_CONFLICT);
        }
        if (empty($password)) {
            return new JsonResponse(['success' => false, 'message' => 'Campo de contraseña vacio.'], JsonResponse::HTTP_CONFLICT);
        }

        // Check if a user with this username already exists
        $userRepository = $this->entityManager->getRepository(User::class);
        $existingUser = $userRepository->findOneBy(['username' => $username]);

        if ($existingUser) {
            return new JsonResponse(['success' => false, 'message' => 'El usuario ya existe'], JsonResponse::HTTP_CONFLICT);
        }

        // Create a new user entity
        $user = new User();
        $user->setUsername($username);

        // Encode and set the password
        $hashedPassword = $this->passwordEncoder->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        // Persist the user entity
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Se ha registrado correctamente']);

    }
}
