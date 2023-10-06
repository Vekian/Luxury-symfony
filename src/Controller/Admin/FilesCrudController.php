<?php

namespace App\Controller\Admin;

use App\Entity\Files;
use App\Extensions\CustomEasyAdminExtension;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FilesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Files::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ImageField::new('source')
            ->setBasePath('assets/files')
            ->setUploadDir('public/assets/files'),

        ];
    }
    
}
