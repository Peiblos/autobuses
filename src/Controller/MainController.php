<?php

namespace App\Controller;

use App\Repository\ViajeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'app_main')]
    public function index(ViajeRepository $viajeRepository): Response
    {
        $viajes = $viajeRepository->findAll();
        dd($viajes);
        return $this->render('main/index.html.twig', [
            'viajes' => $viajes,
        ]);
    }
}
