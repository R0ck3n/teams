<?php

namespace App\Controller;

use App\Entity\Peoples;
use App\Entity\Teams;
use App\Form\PeoplesType;
use App\Form\TeamsType;
use App\Repository\TeamsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(TeamsRepository $teamsRepository): Response
    {   
        $teams = $teamsRepository->findAll();


        return $this->render('pages/home.html.twig', [
            'teams' => $teams,
        ]);

    }

    #[Route('/builder', name: 'app_builder')]
    public function builder(TeamsRepository $teamsRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $team = new Teams();

        // Form team
        $teamform = $this->createForm(TeamsType::class, $team);
        $teamform->handleRequest($request);

        if ($teamform->isSubmitted() && $teamform->isValid()) {
            $entityManager->persist($team);
            $entityManager->flush();

            return $this->redirectToRoute('app_builder', [], Response::HTTP_SEE_OTHER);
        }

        // Form people
        $people = new Peoples();
        $peopleform = $this->createForm(PeoplesType::class, $people);
        $peopleform->handleRequest($request);

        if ($peopleform->isSubmitted() && $peopleform->isValid()) {
            $entityManager->persist($people);
            $entityManager->flush();

            return $this->redirectToRoute('app_builder', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/builder.html.twig', [
            'teams' => $teamsRepository->findAll(),
            'teamform' => $teamform,
            'peopleform' => $peopleform,
            'teams' => $teamsRepository->findAll()
        ]);

    }
}
