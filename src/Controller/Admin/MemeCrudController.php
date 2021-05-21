<?php

namespace App\Controller\Admin;

use App\Entity\Meme;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MemeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Meme::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
