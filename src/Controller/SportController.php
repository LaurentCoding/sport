<?php

namespace App\Controller;

use App\Entity\Sport;
use App\Form\SportType;
use App\Repository\SportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SportController extends AbstractController
{
    /**
     * Ce controller permet de d'afficher tous les sports
     *
     * @param SportRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/sport', name: 'sport.index', methods: ['GET'])]
    public function index(SportRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {

        $sport = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('pages/sport/index.html.twig', [
           'sports' => $sport,
        ]);
    }

    /**
     * permet de créer un nouveau sport
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/sport/nouveau', 'sport.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager) : Response
    {
        $sport = new Sport();
        $form = $this->createForm(SportType::class, $sport);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $sport = $form->getData();

            $manager->persist($sport);
            $manager->flush();

            $this->addFlash(
                'success',
                'Sport bien enregistré !'
            );

            return $this->redirectToRoute('sport.index');
        }

        return $this->render('pages/sport/new.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('/sport/edition/{id}', 'sport.edit', methods: ['GET','POST'])]
    public function edit(Sport $sport, Request $request, EntityManagerInterface $manager) : Response
    {
        
        $form = $this->createForm(SportType::class, $sport);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $sport = $form->getData();

            $manager->persist($sport);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre sport a été modifié avec succès !'
            );

            return $this->redirectToRoute('sport.index');
        }

        return $this->render('pages/sport/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/sport/suppression/{id}', 'sport.delete', methods: ['GET'])]
    public function delete(EntityManagerInterface $manager, Sport $sport) : Response
    {
        $manager->remove($sport);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre sport a été supprimé avec succès !'
        );

        return $this->redirectToRoute('sport.index');
    }
}
