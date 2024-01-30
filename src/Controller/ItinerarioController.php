<?php

namespace App\Controller;

use App\Entity\Itinerario;
use App\Form\ItinerarioType;
use App\Repository\ItinerarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/itinerario')]
class ItinerarioController extends AbstractController
{
    #[Route('/', name: 'app_itinerario_index', methods: ['GET'])]
    public function index(ItinerarioRepository $itinerarioRepository): Response
    {
        return $this->render('itinerario/index.html.twig', [
            'itinerarios' => $itinerarioRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_itinerario_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $itinerario = new Itinerario();
        $form = $this->createForm(ItinerarioType::class, $itinerario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($itinerario);
            $entityManager->flush();

            return $this->redirectToRoute('app_itinerario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('itinerario/new.html.twig', [
            'itinerario' => $itinerario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_itinerario_show', methods: ['GET'])]
    public function show(Itinerario $itinerario): Response
    {
        return $this->render('itinerario/show.html.twig', [
            'itinerario' => $itinerario,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_itinerario_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Itinerario $itinerario, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ItinerarioType::class, $itinerario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_itinerario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('itinerario/edit.html.twig', [
            'itinerario' => $itinerario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_itinerario_delete', methods: ['POST'])]
    public function delete(Request $request, Itinerario $itinerario, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$itinerario->getId(), $request->request->get('_token'))) {
            $entityManager->remove($itinerario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_itinerario_index', [], Response::HTTP_SEE_OTHER);
    }
}
