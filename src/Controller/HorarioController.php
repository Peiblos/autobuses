<?php

namespace App\Controller;

use App\Entity\Horario;
use App\Form\HorarioType;
use App\Repository\HorarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/horario')]
class HorarioController extends AbstractController
{
    #[Route('/', name: 'app_horario_index', methods: ['GET'])]
    public function index(HorarioRepository $horarioRepository): Response
    {
        return $this->render('horario/index.html.twig', [
            'horarios' => $horarioRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_horario_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $horario = new Horario();
        $form = $this->createForm(HorarioType::class, $horario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($horario);
            $entityManager->flush();

            return $this->redirectToRoute('app_horario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('horario/new.html.twig', [
            'horario' => $horario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_horario_show', methods: ['GET'])]
    public function show(Horario $horario): Response
    {
        return $this->render('horario/show.html.twig', [
            'horario' => $horario,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_horario_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Horario $horario, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HorarioType::class, $horario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_horario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('horario/edit.html.twig', [
            'horario' => $horario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_horario_delete', methods: ['POST'])]
    public function delete(Request $request, Horario $horario, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$horario->getId(), $request->request->get('_token'))) {
            $entityManager->remove($horario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_horario_index', [], Response::HTTP_SEE_OTHER);
    }
}
