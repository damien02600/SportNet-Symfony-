<?php

/*
La commande pour les fixture (composer require --dev orm-fixtures).
Je rajoute FakerPHP qui me permet d'avoir des nom plus crédible (composer require fakerphp/faker).
Je commence à remplir l'entité Region car c'est la seule qui n'a pas de clé étrangére.
*/


namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\NumberOfPersons;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {

        // Fixture numberPerson

        $numbers = range(1, 15);
        shuffle($numbers);

        foreach ($numbers as $number) {
            $numberPerson  = new NumberOfPersons();
            $numberPerson->setNumberPerson($number);
            $manager->persist($numberPerson);
        }


        // User

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $myDate = new \DateTime('2023-05-01');

            $user->setUsername($this->faker->name())
                ->setBirthdate($myDate)
                ->setGender(mt_rand(0, 1) == 1 ? true : false)
                ->setMail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPlainPassword('password');

                $manager->persist($user);
        }

        $manager->flush();
    }
}
