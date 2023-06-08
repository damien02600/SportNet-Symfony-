<?php
// J'utilise la commande php bin/console make:admin:crud 
namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

public function configureCrud(Crud $crud): Crud
{
    return $crud
    ->setEntityLabelInPlural('Annonces')
    ->setEntityLabelInSingular('Annonce')
    ->setPageTitle("index","Sportnet - Administration des annonces")
    ->setPaginatorPageSize(10);
}


    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('description'),
            DateTimeField::new('createdAt')
            ->setFormTypeOption('disabled', 'disabled'),
        ];
    }
    
}
