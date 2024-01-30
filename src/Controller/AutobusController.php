<?php

namespace App\Controller;

use App\Entity\Autobus;
use App\Form\AutobusType;
use App\Repository\AutobusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/autobus')]
class AutobusController extends AbstractController
{
    #[Route('/', name: 'app_autobus_index', methods: ['GET'])]
    public function index(AutobusRepository $autobusRepository): Response
    {
        return $this->render('autobus/index.html.twig', [
            'autobuses' => $autobusRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_autobus_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $autobu = new Autobus();
        $form = $this->createForm(AutobusType::class, $autobu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($autobu);
            $entityManager->flush();

            return $this->redirectToRoute('app_autobus_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('autobus/new.html.twig', [
            'autobu' => $autobu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_autobus_show', methods: ['GET'])]
    public function show(Autobus $autobu): Response
    {
        return $this->render('autobus/show.html.twig', [
            'autobu' => $autobu,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_autobus_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Autobus $autobu, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AutobusType::class, $autobu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_autobus_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('autobus/edit.html.twig', [
            'autobu' => $autobu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_autobus_delete', methods: ['POST'])]
    public function delete(Request $request, Autobus $autobu, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$autobu->getId(), $request->request->get('_token'))) {
            $entityManager->remove($autobu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_autobus_index', [], Response::HTTP_SEE_OTHER);
    }
}
