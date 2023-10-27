<?php

namespace App\Controller;

use App\Entity\Clientes;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;




class ClienteController extends AbstractController
{

    #[Route('/cliente', name: 'app_cliente')]
    public function index(): JsonResponse
    {
        return $this->render('index.html.twig');
    }


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/cliente', name: 'app_cliente', methods: ['POST'])]
    public function newCliente(Request $request): JsonResponse
    {
        $content = $request->getContent();
        $data = json_decode($content, true);
        $name = $data['nombre'];

        $cliente = new Clientes();
        $cliente->setNombre($name);

        $this->entityManager->persist($cliente);
        $this->entityManager->flush();

        return new JsonResponse(['message' => 'Se ha guardado correctamente']);
    }

    #[Route('/cliente', name: 'app_cliente', methods: ['GET'])]
    public function getClientes(SerializerInterface $serializer): Response
    {
        $clientRepository = $this->entityManager->getRepository(Clientes::class);
        $clientList = $clientRepository->findAll();
        $serializer->serialize($clientList, 'json');

        return new JsonResponse($clientList, 200, [], true);
    
    }

    #[Route('/cliente/{id}', name: 'app_cliente', methods: ['GET'])]
    public function getCliente($id): JsonResponse
    {
        $clientRepository = $this->entityManager->getRepository(Clientes::class);
        $client = $clientRepository->findOneBy(['id' => $id]);

        return $this->json($client);
    }


    #[Route('/cliente/{id}', name: 'app_cliente', methods: ['PATCH'])]
    public function updateCliente(Request $request, int $id): JsonResponse
    {

        $clientRepository = $this->entityManager->getRepository(Clientes::class);
        $cliente = $clientRepository->findOneBy(['id' => $id]);
        
        if (!$cliente) {
            return $this->json(['message' => 'Cliente no encontrado'], 404);
        }


        $content = $request->getContent();
        $data = json_decode($content, true);
        $cliente->setNombre($data['nombre']);

        $this->entityManager->persist($cliente);
        $this->entityManager->flush();

        return $this->json(['message' => 'Cliente actualizado correctamente']);
    }

    #[Route('/cliente/{id}', name: 'app_cliente', methods: ['DELETE'])]
    public function deleteCliente(int $id): JsonResponse
    {
        $clientRepository = $this->entityManager->getRepository(Clientes::class);
        $cliente = $clientRepository->findOneBy(['id' => $id]);
        
        if (!$cliente) {
            return $this->json(['message' => 'Cliente no encontrado'], 404);
        }

        $this->entityManager->remove($cliente);
        $this->entityManager->flush();

        return $this->json(['message' => 'Cliente eliminado correctamente']);
    }


}
