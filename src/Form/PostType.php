<?php
// Pour créer le formulaire j'ai utilisé la commande "php bin/console make:form"
namespace App\Form;

use App\Entity\Post;
use App\Entity\Level;
use App\Entity\Sports;
use App\Entity\NumberOfPersons;
use App\Repository\LevelRepository;
use App\Repository\SportsRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\NumberOfPersonsRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class PostType extends AbstractType
{

    private $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlenght' => '2',
                    'maxlenght' => '50'
                ],
                'label' => 'Titre de l\'annonce',
                'label_attr' => [
                'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' =>2 , 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'max' => 5
                ],
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])

            ->add('level', EntityType::class, [
                'class' => Level::class,
                'query_builder' => function (LevelRepository $r) {
                    return $r->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC');
                },
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Quels est le niveau des personne que vous recherché',  
                'label_attr' => [
                    'class' => 'form-label mt-4'    
                ],
                'choice_label' => 'name',
            ])   


            ->add('numberofperson', EntityType::class, [
                'class' => NumberOfPersons::class,
                'query_builder' => function (NumberOfPersonsRepository $r) {
                    return $r->createQueryBuilder('i')
                        ->orderBy('i.numberPerson', 'ASC');
                },
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Quels est le nombre de personne que vous recherché',  
                'label_attr' => [
                    'class' => 'form-label mt-4'    
                ],
                'choice_label' => 'numberPerson',
            ])   
            
            ->add('city',  CityAutocompleteField::class)   

            ->add('sport', EntityType::class, [
                'class' => Sports::class,
                'query_builder' => function (SportsRepository $r) {
                    return $r->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC', 'UCASE');
                },
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Quels est le sport que vous souhaité pratiqué',  
                'label_attr' => [
                    'class' => 'form-label mt-4'    
                ],
                'choice_label' => 'name',
                'autocomplete' => true,
            ])   

            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Créer mon annonce'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
