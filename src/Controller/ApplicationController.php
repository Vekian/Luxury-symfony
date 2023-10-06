<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\JobOffer;
use App\Entity\Candidate;
use App\Form\ApplicationType;
use Symfony\Component\Security\Core\Security;
use App\Repository\ApplicationRepository;
use App\Repository\CandidateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/application')]
class ApplicationController extends AbstractController
{

    #[Route('/joboffer/{joboffer}/new', name: 'app_application_new', methods: ['GET', 'POST'])]
    public function new(JobOffer $joboffer, Request $request, EntityManagerInterface $entityManager, CandidateRepository $candidateRepository, Security $security): Response
    {   
        $application = new Application();
        $jobOfferId = $joboffer->getId();
       
        $candidate = $security->getUser()->getCandidate();
        $application->setJobOffer($joboffer);
        $application->setCandidate($candidate);
        $timeZone = new \DateTimeZone('Europe/Paris');
        $application->setCreatedAt(new \DateTimeImmutable('now', $timeZone));
    
        $entityManager->persist($application);
        $entityManager->flush();
        return $this->redirectToRoute('app_job_offer_show', ['id' => $jobOfferId], Response::HTTP_SEE_OTHER);
    }

}
