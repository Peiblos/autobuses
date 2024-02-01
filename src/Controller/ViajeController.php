<?php

namespace App\Controller;

use App\Entity\Itinerario;
use App\Entity\Viaje;
use App\Form\ViajeType;
use App\Repository\ViajeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/viaje')]
class ViajeController extends AbstractController
{
    #[Route('/', name: 'app_viaje_index', methods: ['GET'])]
    public function index(ViajeRepository $viajeRepository): Response
    {
        return $this->render('viaje/index.html.twig', [
            'viajes' => $viajeRepository->findAll(),
        ]);
    }

    #[Route('/check/{id}', name: 'app_viaje_check', methods: ['POST'])]
    public function check(Viaje $viaje, ViajeRepository $viajeRepository,Request $request): Response
    {
        $filas = $viaje->getAutobus()->getFilas();
        $columnas = $viaje->getAutobus()->getColumnas();
        $asientos = $request->get('asientos');
        $coordenadas = [];
        foreach ($asientos as $asiento){
            $coordenadas[] = [floor($asiento/$columnas), $asiento%$columnas];
        }
        return $this->render('viaje/confirmar.html.twig', [
            'coordenadas' => $coordenadas,
        ]);
    }

    #[Route('/confirmar/{id}', name: 'polal', methods: ['POST'])]
    public function confirmacion(ViajeRepository $viajeRepository,Request $request): Response
    {
        $coordenadas = json_decode($request->get('coordenadas'));
        
        return $this->render('viaje/billete.html.twig', [
        ]);
    }

    #[Route('/billetes/{id}', name: 'app_viaje_billete', methods: ['GET'])]
    public function billete(Viaje $viaje,ViajeRepository $viajeRepository): Response
    {
        return $this->render('viaje/billete.html.twig', [
            'asientos' => $viaje->getAsientos(),
            'viaje' => $viaje,
        ]);
    }

    #[Route('/new', name: 'app_viaje_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $viaje = new Viaje();
        $form = $this->createForm(ViajeType::class, $viaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $viaje->calcularAsientos();
            $entityManager->persist($viaje);
            $entityManager->flush();

            return $this->redirectToRoute('app_viaje_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('viaje/new.html.twig', [
            'viaje' => $viaje,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_viaje_show', methods: ['GET'])]
    public function show(Itinerario $itinerario, ViajeRepository $viajeRepository): Response
    {
         
        $viajes  = $viajeRepository->findBy(['itinerario' => $itinerario]);
        return $this->render('viaje/show.html.twig', [
            'viajes' => $viajes,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_viaje_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Viaje $viaje, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ViajeType::class, $viaje);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_viaje_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('viaje/edit.html.twig', [
            'viaje' => $viaje,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_viaje_delete', methods: ['POST'])]
    public function delete(Request $request, Viaje $viaje, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$viaje->getId(), $request->request->get('_token'))) {
            $entityManager->remove($viaje);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_viaje_index', [], Response::HTTP_SEE_OTHER);
    }

}
