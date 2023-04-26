<?php

namespace App\Form;

use App\Entity\City;
use App\Repository\CityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\ParentEntityAutocompleteType;

#[AsEntityAutocompleteField]
class CityAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => City::class,
            'placeholder' => 'Choissisez la ville ou vous vouler pratiquer',
            'choice_label' => 'city_name',
            'attr' => [
                'class' => 'form-control',
            ],
            'label_attr' => [
                'class' => 'form-label mt-4'    
            ],

            'query_builder' => function(CityRepository $cityRepository) {
                return $cityRepository->createQueryBuilder('city');
            },
            //'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return ParentEntityAutocompleteType::class;
    }
}
