<?php 

namespace App\Controller\Admin;

use App\Entity\JobOffer;
use App\Repository\JobOfferRepository;
use App\Repository\CandidateRepository;
use App\Repository\ApplicationRepository;
use App\Repository\ClientRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("is_granted('ROLE_ADMIN')")
 */
class BusinessStatsController extends AbstractController
{
    public function __construct(JobOfferRepository $jobOfferRepository, CandidateRepository $candidateRepository, ApplicationRepository $applicationRepository, ClientRepository $clientRepository)
    {
        $this->jobOfferRepository = $jobOfferRepository;
        $this->candidateRepository = $candidateRepository;
        $this->applicationRepository = $applicationRepository;
        $this->clientRepository = $clientRepository;
    }

    #[Route('/admin/business-stats', name: 'admin_business_stats')]
    public function index()
    {
        $totalJobOffers = count($this->jobOfferRepository->findAll());
        $totalCandidates = count($this->candidateRepository->findAll());
        $totalApplications = count($this->applicationRepository->findAll());
        $totalClients = count($this->clientRepository->findAll());
        return $this->render('admin/business_stats/index.html.twig', [
            'dataJobs' => $totalJobOffers,
            'dataCandidates' => $totalCandidates,
            'dataApplications' => $totalApplications,
            'dataClients' => $totalClients,

        ]);
    }
}