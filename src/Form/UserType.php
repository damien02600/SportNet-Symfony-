<?php
// Je créer un formulaire
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('username', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'minlenght' => '2',
                'maxlenght' => '50',
            ],
            'label' => 'Votre pseudo',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\Length(['min'=> 2, 'max'=> 50]),
                new Assert\NotBlank(),
            ]
        ])
        ->add('mail', EmailType::class, [
            'attr' => [
                'class' => 'form-control',
                'minlenght' => '2',
                'maxlenght' => '180',
            ],
            'label' => 'Votre emal',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ],
            'constraints' => [
                new Assert\Length(['min'=> 2, 'max'=> 180]),
                new Assert\NotBlank(),
                new Assert\Email(),
            ]
        ])
        ->add('gender', ChoiceType::class, [
            'choices'  => [
                'Homme' => true,
                'Femme' => false,
            ],
            'attr' => [
                'class' => 'form-control',
            ],
            'label' => 'Votre sexe',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]
            ])
        ->add('birthdate', DateType::class, [
            'widget' => 'choice',
            'attr' => [
                'class' => 'form-control',
            ],
            'label' => 'Votre date de naissance',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]
        ])

        ->add('plainPassword', PasswordType::class, [
            'attr' => [
                'class' => 'form-control'
            ],
            'label' => 'Mot de passe',
            'label_attr' => 'Mot de passe',
            'label_attr' => [
                'class' => 'form-label mt-4'
            ]
        ])
        ->add('Valider', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary mt-4'
            ]
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
