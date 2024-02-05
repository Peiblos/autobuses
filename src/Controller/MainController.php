<?php

namespace App\Controller;

use App\Repository\ViajeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(ViajeRepository $viajeRepository, EntityManagerInterface $entityManager): Response
    {
        return $this->render('main/index.html.twig', [
            'venta' => null
        ]);
    }
}
