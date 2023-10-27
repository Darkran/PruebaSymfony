<?php

namespace App\Controller;

use App\Entity\Maquinas;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MaquinaController extends AbstractController
{

    #[Route('/maquina', name: 'app_maquina')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MaquinaController.php',
        ]);
    }

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function newMaquina(Request $request): JsonResponse
    {

        $content = $request->getContent();
        $data = json_decode($content, true);

        $maquina = new Maquinas();
        $maquina->setNombre($data['nombre']);
        $maquina->setCliente($data['cliente']);
        $maquina->setTipo($data['tipo']);
        $maquina->addVideo($data['videos']);

        // Persist the user entity
        $this->entityManager->persist($maquina);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Se ha guardado correctamente']);
    }

    public function getMaquinas(): JsonResponse
    {
    }

    public function updateMaquina(Request $request, int $id): JsonResponse
    {


        return $this->json(['message' => 'Maquina actualizada correctamente']);
    }

    public function deleteMaquina(int $id): JsonResponse
    {

        return $this->json(['message' => 'Maquina eliminada correctamente']);
    }
}
