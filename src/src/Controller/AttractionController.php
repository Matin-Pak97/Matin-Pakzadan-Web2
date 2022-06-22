<?php

namespace App\Controller;

use App\Entity\Attraction;
use App\Repository\AttractionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AttractionController extends AbstractController
{
    /* @var AttractionRepository $attractionRepository */
    private $attractionRepository;

    /* @var EntityManagerInterface $entityManager */
    private $entityManager;

    public function __construct(
        AttractionRepository $attractionRepository,
        EntityManagerInterface $entityManager,
    )
    {
        $this->attractionRepository = $attractionRepository;
        $this->entityManager        = $entityManager;
    }

    #[Route('/attractions', name: 'app_attractions')]
    public function index(): Response
    {
        $attractions = $this->attractionRepository->findAll();

        return $this->render('attraction/index.html.twig', [
            'attractions' => $attractions,
        ]);
    }

    #[Route('/attraction/new', name: 'app_attraction_new')]
    public function new(Request $request): Response | RedirectResponse
    {
        if ($request->isMethod("POST")) {
            $name = $request->get('name');
            $shortDesc = $request->get('short_description');
            $fullDesc = $request->get('full_description');
            $score = $request->get('score');

            $attraction = new Attraction();
            $attraction->setName($name);
            $attraction->setShortDescription($shortDesc);
            $attraction->setFullDescription($fullDesc);
            $attraction->setScore($score);

            $this->entityManager->persist($attraction);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_attractions');
        }
        return $this->render('attraction/new.html.twig');
    }

    #[Route('/attraction/{id}', name: 'app_attraction_view')]
    public function view(Attraction $attraction): Response | RedirectResponse
    {
        return $this->render('attraction/view.html.twig', ['entity' => $attraction]);
    }

    #[Route('/attraction/edit/{id}', name: 'app_attraction_edit')]
    public function edit(Request $request, Attraction $attraction): Response | RedirectResponse
    {
        if ($request->isMethod("POST")) {
            $name = $request->get('name');
            $shortDesc = $request->get('short_description');
            $fullDesc = $request->get('full_description');
            $score = $request->get('score');

            $attraction->setName($name);
            $attraction->setShortDescription($shortDesc);
            $attraction->setFullDescription($fullDesc);
            $attraction->setScore($score);

            $this->entityManager->persist($attraction);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_attractions');
        }
        return $this->render('attraction/edit.html.twig', [ 'entity' => $attraction ]);
    }

    #[Route('/attraction/delete/{id}', name: 'app_attraction_delete')]
    public function delete(Attraction $attraction): Response | RedirectResponse
    {
        $this->entityManager->remove($attraction);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_attractions');
    }
}
