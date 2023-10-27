<?php

namespace App\Controller;

use App\Entity\Videos;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VideosController extends AbstractController
{
    #[Route('/videos', name: 'app_videos')]
    public function index(): JsonResponse
    {
        return $this->render('index.html.twig');
    }

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/video', name: 'app_video', methods: ['POST'])]
    public function newVideo(Request $request): JsonResponse
    {
        $content = $request->getContent();
        $data = json_decode($content, true);
        $name = $data['nombre'];
        $duration = intval($data['duracion']);

        // Create a new entity
        $video = new Videos();
        $video->setNombre($name);
        $video->setDuracion($duration);

        // Persist the user entity
        $this->entityManager->persist($video);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Se ha guardado correctamente']);
    }




}
