<?php

namespace App\Controller\Admin;

use App\Entity\Candidate;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CandidateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Candidate::class;
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
            TextField::new('firstName'),
            TextField::new('lastName'),
            AssociationField::new('profilPicture')->renderAsEmbeddedForm(FilesCrudController::class)->hideOnIndex(),
            AssociationField::new('cv')->renderAsEmbeddedForm(FilesCrudController::class)->hideOnIndex(),
            AssociationField::new('passportFile', 'PassportSource')->renderAsEmbeddedForm(FilesCrudController::class)->hideOnIndex(),
            AssociationField::new('notes')->renderAsEmbeddedForm(NotesCrudController::class)->hideOnIndex(),
            AssociationField::new('user')->renderAsEmbeddedForm(UserCrudController::class),
            AssociationField::new('jobCategory'),
            AssociationField::new('experience')->hideOnIndex(),
            ChoiceField::new('gender')->setChoices([
                'Female' => 'female',
                'Male' => 'male',
                'Transgender' => 'transgender',
            ])->hideOnIndex(),
            TextField::new('country')->hideOnIndex(),
            TextField::new('nationality')->hideOnIndex(),
            TextField::new('currentLocation'),
            TextField::new('birthPlace')->hideOnIndex(),
            TextField::new('adress'),
            TextField::new('description')->hideOnIndex(),
            DateTimeField::new('createdAt')->hideOnForm(),
            ArrayField::new('applications')->hideOnForm()->setTemplatePath('admin/detail/applications.html.twig'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, 'detail');
    }

}
