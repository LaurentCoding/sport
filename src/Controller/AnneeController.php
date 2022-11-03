<?php

namespace App\Controller;

use App\Entity\Annee;
use App\Form\AnneeType;
use App\Repository\AnneeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnneeController extends AbstractController
{
    /**
     * Ce controller permet d'afficher toutes les années 
     *
     * @param AnneeRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/annee', name: 'annee.index', methods: ['GET'])]
    public function index(AnneeRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $annees = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        
        return $this->render('pages/annee/index.html.twig', [
           'annees' => $annees
        ]);
    }

   
    /**
     * Controlleur pour la creation d'une nouvelle année
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/annee/nouveau', name: 'annee.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $annee = new Annee();
        $form = $this->createForm(AnneeType::class, $annee);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $form->getData();

            $manager->persist($annee);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre année a bien été enregistrée !'
            );

            return $this->redirectToRoute('annee.index');
        }

        return $this->render('pages/annee/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

   
     /**
     * Controlleur pour la modification d'un année
     *
     * @param Annee $annee
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/annee/edition/{id}', 'annee.edit', methods: ['GET', 'POST'])]
    public function edit(Annee $annee, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(AnneeType::class, $annee);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $annee = $form->getData();

            $manager->persist($annee);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre année a été modifiée avec succès !'
            );
            return $this->redirectToRoute('annee.index');
        }

        return $this->render('pages/annee/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/annee/suppression/{id}', 'annee.delete', methods: ['GET', 'POST'])]
    public function delete(Annee $annee, EntityManagerInterface $manager): Response
    {

        $manager->remove($annee);
        $manager->flush();

        $this->addFlash(
            'success',
            'Votre année a été supprimée avec succès !'
        );

        return $this->redirectToRoute('annee.index');
    }
}
