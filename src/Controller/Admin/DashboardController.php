<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Entity\JobOffer;
use App\Entity\Candidate;
use App\Entity\JobType;
use App\Entity\JobCategory;
use App\Entity\Files;
use App\Entity\Notes;
use App\Entity\Application;
use App\Entity\Experience;
use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator){

    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $url = $this->adminUrlGenerator->setController(ClientCrudController::class)->generateUrl();
        return $this->redirect($url);


    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Luxury');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoRoute('Stats', 'fa fa-chart-bar', 'admin_business_stats');
        
        yield MenuItem::section('Jobs');
        yield MenuItem::subMenu('Clients', 'fa-solid fa-user-tie')->setSubItems([
            MenuItem::linkToCrud('Add client', 'fa-solid fa-user', Client::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Clients', 'fa-solid fa-eye', Client::class)
        ]);
        yield MenuItem::subMenu('Job Offers', 'fa-solid fa-file-invoice-dollar')->setSubItems([
            MenuItem::linkToCrud('Add Job Offer', 'fa-solid fa-person-digging', JobOffer::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Job Offers', 'fa-solid fa-eye', JobOffer::class)
        ]);
        yield MenuItem::subMenu('Applications', 'fa-solid fa-file-pen')->setSubItems([
            MenuItem::linkToCrud('Add Application', 'fa-solid fa-file-pen', Application::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Applications', 'fa-solid fa-eye', Application::class)
        ]);
        yield MenuItem::subMenu('Candidates', 'fa-solid fa-users')->setSubItems([
            MenuItem::linkToCrud('Add candidate', 'fa-solid fa-person-digging', Candidate::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Candidates', 'fa-solid fa-eye', Candidate::class)
        ]);

        yield MenuItem::section('Assets');
        yield MenuItem::subMenu('Files', 'fa-solid fa-laptop-file')->setSubItems([
            MenuItem::linkToCrud('Add File', 'fa-solid fa-user', Files::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Files', 'fa-solid fa-eye', Files::class)
        ]);
        yield MenuItem::subMenu('JobType', 'fa-solid fa-calendar')->setSubItems([
            MenuItem::linkToCrud('Add JobType', 'fa-solid fa-user', JobType::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show JobTypes', 'fa-solid fa-eye', JobType::class)
        ]);
        yield MenuItem::subMenu('JobCategories', 'fa-solid fa-list-ol')->setSubItems([
            MenuItem::linkToCrud('Add JobCategory', 'fa-solid fa-user', JobCategory::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show JobCategory', 'fa-solid fa-eye', JobCategory::class)
        ]);
        yield MenuItem::subMenu('Experience', 'fa-solid fa-person-cane')->setSubItems([
            MenuItem::linkToCrud('Add Experience', 'fa-solid fa-user', Experience::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Experience', 'fa-solid fa-eye', Experience::class)
        ]);

        yield MenuItem::section('Admin');
        yield MenuItem::subMenu('Notes', 'fa-solid fa-note-sticky')->setSubItems([
            MenuItem::linkToCrud('Add note', 'fa-regular fa-note-sticky', Notes::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show Notes', 'fa-solid fa-eye', Notes::class)
        ]);
        yield MenuItem::subMenu('User', 'fa-solid fa-user')->setSubItems([
            MenuItem::linkToCrud('Add User', 'fa-regular fa-note-sticky', User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Show User', 'fa-solid fa-eye', User::class)
        ]);
        
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
