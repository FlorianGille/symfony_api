<?php

namespace App\Controller;

use App\Repository\MarqueRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MarqueController
{
    private $marqueRepository;

    public function __construct(MarqueRepository $marqueRepository)
    {
        $this->marqueRepository = $marqueRepository;
    }

    /**
     * @Route("/marque/add", name="add_marque", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nom = $data['nom'];

        if (empty($nom)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->marqueRepository->saveMarque($nom);

        return new JsonResponse(['status' => 'Marque created!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/marque/{id}", name="get_one_marque", methods={"GET"})
     */
    public function getOne($id): JsonResponse
    {
        $marque = $this->marqueRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $marque->getId(),
            'nom' => $marque->getNom(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/marques", name="get_all_marques", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $marques = $this->marqueRepository->findAll('id');

        return new JsonResponse($marques, Response::HTTP_OK);
    }

    /**
     * @Route("/marque/update/{id}", name="update_marque", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $marque = $this->marqueRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['nom']) ? true : $marque->setNom($data['nom']);

        $updatedMarque = $this->marqueRepository->updateMarque($marque);

        return new JsonResponse($updatedMarque->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/marque/delete/{id}", name="delete_marque", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $marque = $this->marqueRepository->findOneBy(['id' => $id]);

        $this->marqueRepository->removeMarque($marque);

        return new JsonResponse(['status' => 'Marque deleted'], Response::HTTP_NO_CONTENT);
    }
}