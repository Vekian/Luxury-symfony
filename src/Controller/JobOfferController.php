<?php

namespace App\Controller;

use App\Entity\JobOffer;
use Symfony\Component\Security\Core\Security;
use App\Form\JobOfferType;
use App\Entity\Application;
use App\Form\ApplicationType;
use App\Repository\JobOfferRepository;
use App\Repository\ApplicationRepository;
use App\Repository\JobCategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class JobOfferController extends AbstractController
{
    #[Route('/', name: 'app_index', methods: ['GET'])]
    public function index(JobOfferRepository $jobOfferRepository, JobCategoryRepository $jobCategoryRepository, ApplicationRepository $applicationRepository, Security $security): Response
    {
        $jobOffers = $jobOfferRepository->findAll();
        $user = $security->getUser();
        if(isset($user)){
            $userId = $user->getCandidate()->getId();
        foreach($jobOffers as $job){
            $application = $applicationRepository->findOneBy(['candidate' => $userId,
            'jobOffer' => $job->getId()]);
            if(isset($application)) {
                $job->setApplicated(true);
            }
        }
        }
        
        
        return $this->render('job_offer/index.html.twig', [
            'job_offers' => $jobOfferRepository->findAll(),
            'job_categorys' => $jobCategoryRepository->findAll(),
        ]);
    }

    #[Route('/jobs', name: 'app_jobs')]
    public function jobs(JobOfferRepository $jobOfferRepository, JobCategoryRepository $jobCategoryRepository, ApplicationRepository $applicationRepository, Security $security): Response
    {
        $jobOffers = $jobOfferRepository->findAll();
        $user = $security->getUser();
        if(isset($user)){
            $userId = $user->getCandidate()->getId();
        foreach($jobOffers as $job){
            $application = $applicationRepository->findOneBy(['candidate' => $userId,
            'jobOffer' => $job->getId()]);
            if(isset($application)) {
                $job->setApplicated(true);
            }
        }
        }

        return $this->render('job_offer/jobs.html.twig', [
            'controller_name' => 'JobOfferController',
            'job_offers' => $jobOffers,
            'job_categorys' => $jobCategoryRepository->findAll(),
        ]);
    }

    #[Route('/jobs/new', name: 'app_job_offer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $jobOffer = new JobOffer();
        $form = $this->createForm(JobOfferType::class, $jobOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($jobOffer);
            $entityManager->flush();

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('job_offer/new.html.twig', [
            'job_offer' => $jobOffer,
            'form' => $form,
            
        ]);
    }

    #[Route('/jobs/{id}', name: 'app_job_offer_show', methods: ['GET'])]
    public function show(Request $request, JobOffer $jobOffer, JobOfferRepository $jobOfferRepository, ApplicationRepository $applicationRepository, Security $security): Response
    {
        $currentId = $jobOffer->getId();
        $user = $security->getUser();
        $userId = $user->getCandidate()->getId();
        
        $application = $applicationRepository->findOneBy(['candidate' => $userId,
                                            'jobOffer' => $currentId]);
        if(isset($application)) {
            $jobOffer->setApplicated(true);
        }

        // Récupérez l'ID de l'offre précédente
        $previousIdArray = $jobOfferRepository->getPreviousJobOfferId($currentId);
        if(isset($previousIdArray)){
            $previousId = $previousIdArray['id'];
        }
        else {
            $previousId = null;
        }
        $nextIdArray = $jobOfferRepository->getNextJobOfferId($currentId);
        if(isset($nextIdArray)){
            $nextId = $nextIdArray['id'];
        }
        else {
            $nextId = null;
        }

        return $this->render('job_offer/show.html.twig', [
            'job_offer' => $jobOffer,
            'previousId' => $previousId,
            'nextId' => $nextId,
        ]);
    }

    #[Route('/jobs/{id}/edit', name: 'app_job_offer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, JobOffer $jobOffer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(JobOfferType::class, $jobOffer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('job_offer/edit.html.twig', [
            'job_offer' => $jobOffer,
            'form' => $form,
        ]);
    }

    #[Route('/jobs/{id}', name: 'app_job_offer_delete', methods: ['POST'])]
    public function delete(Request $request, JobOffer $jobOffer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jobOffer->getId(), $request->request->get('_token'))) {
            $entityManager->remove($jobOffer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_index', [], Response::HTTP_SEE_OTHER);
    }
}
