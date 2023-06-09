<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Service\MailerService;
use App\Form\OffreType;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/offre')]
class OffreController extends AbstractController
{
    #[Route('/', name: 'app_offre_index', methods: ['GET'])]
    public function indexAdminConducteur(OffreRepository $offreRepository): Response
    {
        return $this->render('offre/index.html.twig', [
            'offres' => $offreRepository->findAll(),
        ]);
    }
    #[Route('/admin', name: 'app_offre_index_admin', methods: ['GET'])]
    public function indexAdmin(OffreRepository $offreRepository): Response
    {
        return $this->render('offre/indexAdmin.html.twig', [
            'offres' => $offreRepository->findAll(),
        ]);
    }
    #[Route('/listOffre', name: 'app_offre_index_Client', methods: ['GET'])]
    public function indexClient(OffreRepository $offreRepository): Response
    {
        return $this->render('offre/indexClient.html.twig', [
            'offres' => $offreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_offre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, OffreRepository $offreRepository): Response
    {
         
             
        $offre = new Offre();
        
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $offreRepository->save($offre, true);
            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('offre/new.html.twig', [
            'offre' => $offre,
            'form' => $form,
        ]);
    }
    
    #[Route('front/new', name: 'app_offre_new_front', methods: ['GET', 'POST'])]
    public function newfront(Request $request, OffreRepository $offreRepository): Response
    {
         
             
        $offre = new Offre();
        
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $offreRepository->save($offre, true);
            return $this->redirectToRoute('app_offre_index_Client', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('offre/newfront.html.twig', [
            'offre' => $offre,
            'form' => $form,
        ]);
    }

    #[Route('reserver/new', name: 'app_offre_new_reserver', methods: ['GET', 'POST'])]
    public function newreserver(Request $request, OffreRepository $offreRepository): Response
    {
         
             
        $offre = new Offre();
        
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $offreRepository->save($offre, true);
            return $this->redirectToRoute('app_offre_index_Client', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('offre/newadmin.html.twig', [
            'offre' => $offre,
            'form' => $form,
        ]);
    }

    #[Route('/{idOffre}', name: 'app_offre_show', methods: ['GET'])]
    public function show(Offre $offre): Response
    {
        return $this->render('offre/show.html.twig', [
            'offre' => $offre,
        ]);
    }
    #[Route('/front/{idOffre}', name: 'app_offre_show_client', methods: ['GET'])]
    public function showfront(Offre $offre): Response
    {
      
        return $this->render('offre/showfront.html.twig', [
            'offre' => $offre,
        ]);
    }
    #[Route('/admin/{idOffre}', name: 'app_offre_show_admin', methods: ['GET'])]
    public function showAdmin(Offre $offre): Response
    {
      
        return $this->render('offre/showAdmin.html.twig', [
            'offre' => $offre,
        ]);
    }
     

    #[Route('/{idOffre}/edit', name: 'app_offre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offre $offre, OffreRepository $offreRepository, MailerService $mailer
    ): Response
    {
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offreRepository->save($offre, true);
            $mailMessage = $offre->getIdOffre();
            $this->addFlash('succes', $offre->getIdOffre());
            $mailer->sendEmail(content: $mailMessage);


            return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('offre/edit.html.twig', [
            'offre' => $offre,
            'form' => $form,
        ]);
    }

    #[Route('/editfront/{idOffre}', name: 'app_offre_edit_front', methods: ['GET', 'POST'])]
    public function editfront(Request $request, Offre $offre, OffreRepository $offreRepository, MailerService $mailer
    ): Response
    {
        $form = $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offreRepository->save($offre, true);
            $mailMessage = $offre->getIdOffre();
            $this->addFlash('succes', $offre->getIdOffre());
            $mailer->sendEmail(content: $mailMessage);


            return $this->redirectToRoute('app_offre_indexClient', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('offre/editfront.html.twig', [
            'offre' => $offre,
            'form' => $form,
        ]);
    }


    //#[Route('/b', name: 'app_offre_indexb', methods: ['GET'])]
    //public function index(OffreRepository $offreRepository): Response
    //{
        //return $this->render('offre/index.html.twig', [
            //'offres' => $offreRepository->findAll(),
        //]);
    //}

    #[Route('/{idOffre}', name: 'app_offre_delete', methods: ['POST'])]
    public function delete(Request $request, Offre $offre, OffreRepository $offreRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offre->getIdOffre(), $request->request->get('_token'))) {
            $offreRepository->remove($offre, true);
        }

        return $this->redirectToRoute('app_offre_index', [], Response::HTTP_SEE_OTHER);
    }

     


    
}
