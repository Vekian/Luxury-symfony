<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use App\Entity\Application;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ApplicationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Application::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['createdAt' => 'DESC']); // Tri par ordre décroissant du champ createdAt
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('candidate')->onlyOnForms(),
            AssociationField::new('candidate', 'Candidate Name')->formatValue(function ($value, $entity) {
 
                    return $entity->getCandidate()->getFirstName() . ' ' . $entity->getCandidate()->getLastName();
                
            })->autocomplete()->hideOnForm(),
            AssociationField::new('candidate', 'Candidate Email')->formatValue(function ($value, $entity) {

                return $entity->getCandidate()->getUser()->getEmail();
            
            })->autocomplete()->hideOnForm(),
            AssociationField::new('candidate', 'Profil Picture')->formatValue(function ($value, $entity) {
 
                return $entity->getCandidate()->getProfilPicture();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('candidate', 'CV')->formatValue(function ($value, $entity) {
 
                return $entity->getCandidate()->getCv();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('candidate', 'PassportSource')->formatValue(function ($value, $entity) {
 
                return $entity->getCandidate()->getPassportFile();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('candidate', 'Job Category Of Candidate')->formatValue(function ($value, $entity) {
 
                return $entity->getCandidate()->getJobCategory();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('candidate', 'Experience')->formatValue(function ($value, $entity) {
 
                return $entity->getCandidate()->getExperience();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('candidate', 'Gender')->formatValue(function ($value, $entity) {
 
                return $entity->getCandidate()->getGender();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('candidate', 'Country')->formatValue(function ($value, $entity) {
 
                return $entity->getCandidate()->getCountry();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('candidate', 'Nationality')->formatValue(function ($value, $entity) {
 
                return $entity->getCandidate()->getNationality();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('candidate', 'Current Location')->formatValue(function ($value, $entity) {
 
                return $entity->getCandidate()->getCurrentLocation();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('candidate', 'BirthPlace')->formatValue(function ($value, $entity) {
 
                return $entity->getCandidate()->getBirthPlace();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('candidate', 'Adress')->formatValue(function ($value, $entity) {
 
                return $entity->getCandidate()->getAdress();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('candidate', 'Description')->formatValue(function ($value, $entity) {
 
                return $entity->getCandidate()->getDescription();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('candidate', 'Candidate CreatedAt')->formatValue(function ($value, $entity) {
 
                return $entity->getCandidate()->getCreatedAt()->format('Y-m-d H:i:s');
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('jobOffer', 'Job Title')->formatValue(function ($value, $entity) {
 
                return $entity->getJobOffer()->getJobTitle();
            
            })->autocomplete()->hideOnForm(),
            AssociationField::new('jobOffer', 'Society Name')->formatValue(function ($value, $entity) {
                return $entity->getJobOffer()->getClient()->getSocietyName();
            
            })->autocomplete()->hideOnForm(),
            AssociationField::new('jobOffer', 'Job Type')->formatValue(function ($value, $entity) {
 
                return $entity->getJobOffer()->getJobType();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('jobOffer', 'Job Category')->formatValue(function ($value, $entity) {
 
                return $entity->getJobOffer()->getJobCategory();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('jobOffer', 'Reference')->formatValue(function ($value, $entity) {
 
                return $entity->getJobOffer()->getReference();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('jobOffer', 'Description')->formatValue(function ($value, $entity) {
 
                return $entity->getJobOffer()->getDescription();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('jobOffer', 'Activated')->formatValue(function ($value, $entity) {
 
                return $entity->getJobOffer()->isActivated();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('jobOffer', 'Location')->formatValue(function ($value, $entity) {
 
                return $entity->getJobOffer()->getLocation();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('jobOffer', 'ClosingDate')->formatValue(function ($value, $entity) {
 
                return $entity->getJobOffer()->getClosingDate()->format('Y-m-d H:i:s');
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('jobOffer', 'Salary')->formatValue(function ($value, $entity) {
 
                return $entity->getJobOffer()->getSalary();
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('jobOffer', 'Contact Name')->formatValue(function ($value, $entity) {
                return $entity->getJobOffer()->getClient()->getContactName();
            
            })->autocomplete()->hideOnForm(),
            AssociationField::new('jobOffer', 'Contact Email')->formatValue(function ($value, $entity) {
                return $entity->getJobOffer()->getClient()->getContactEmail();
            
            })->autocomplete()->hideOnForm(),
            AssociationField::new('jobOffer', 'JobOffer CreatedAt')->formatValue(function ($value, $entity) {
 
                return $entity->getJobOffer()->getCreatedAt()->format('Y-m-d H:i:s');
            
            })->autocomplete()->onlyOnDetail(),
            AssociationField::new('jobOffer')->onlyOnForms(),
            TextField::new('notes')->hideOnForm(),
            DateTimeField::new('createdAt')->hideOnForm(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, 'detail');
    }

}
