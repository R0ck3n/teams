<?php

namespace App\Controller;

use App\Repository\TeamsRepository;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(TeamsRepository $teamsRepository): Response
    {

        return $this->render('pages/home.html.twig', [
            'teams' => $teamsRepository->findAll(),
        ]);

    }

    #[Route('/builder', name: 'app_builder')]
    public function builder(TeamsRepository $teamsRepository): Response
    {

        return $this->render('pages/builder.html.twig', [
            'teams' => $teamsRepository->findAll(),
        ]);

    }
}
