<?php

/*
La commande pour les fixture (composer require --dev orm-fixtures).
Je rajoute FakerPHP qui me permet d'avoir des nom plus crédible (composer require fakerphp/faker).
Je commence à remplir l'entité Region car c'est la seule qui n'a pas de clé étrangére.
*/


namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\City;
use App\Entity\Post;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Level;
use Doctrine\ORM\Cache\Region;
use App\Entity\NumberOfPersons;
use App\Entity\Sports;
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



        // User
        $user = [];
        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $myDate = new \DateTime('2023-05-01');

            $user->setUsername($this->faker->word())
                ->setBirthdate($myDate)
                ->setGender(mt_rand(0, 1) == 1 ? true : false)
                ->setMail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                /* Je lui set un PlainPassword,
                            il va les persisté, et aller dans User.php voir le entitylISTENER 
                            j'encode le password grace au entityListeners (UserListener.php) */
                ->setPlainPassword('password');
            $users[] = $user;

            $manager->persist($user);
        }




        // Fixture villes
        // Je commence à remplir l'entité Region car c'est la seule qui n'a pas de clé étrangére.

        $city = [];
        for ($i = 0; $i < 50; $i++) {
            $city = new City();
            $city->setInseeCode(mt_rand(1000, 99999))
                ->setCityName($this->faker->word())
                ->setPostalCode(mt_rand(1000, 99999))
                ->setDepartmentName($this->faker->word())
                ->setRegionName($this->faker->word());
            $citys[] = $city;

            $manager->persist($city);
        }
                // Fixture numberPerson

                $numberPerson = [];
                for ($i = 0; $i < 10; $i++) {
                    $numberPerson = new NumberOfPersons();
                    $numberPerson->setNumberPerson(mt_rand(1, 10));
                    $numberPersons[] = $numberPerson;
        
                    $manager->persist($numberPerson);
                }

        // Fixture levels
        // Je commence à remplir l'entité Region car c'est la seule qui n'a pas de clé étrangére.

        $level = [];
        for ($i = 0; $i < 3; $i++) {
            $level = new Level();
            $level->setName($this->faker->word());
            $levels[] = $level;

            $manager->persist($level);
        }


        // Fixture sport

        $sport = [];
        for ($i = 0; $i < 3; $i++) {
            $sport = new Sports();
            $sport->setName($this->faker->word());
            $sports[] = $sport;

            $manager->persist($sport);
        }


        // Fixture numberPerson

        $numbers = range(1, 15);
        shuffle($numbers);

        $numberPerson = [];
        foreach ($numbers as $number) {
            $numberPerson  = new NumberOfPersons();
            $numberPerson->setNumberPerson($number);
            $numberPersons[] = $numberPerson;
            $manager->persist($numberPerson);
        }


        // Fixture Post

        for ($i = 0; $i < 50; $i++) {
            $post = new Post();
            $post->setTitle($this->faker->word())
                ->setDescription($this->faker->text(300))
                ->setCity($citys[mt_rand(0, count($citys) - 1)])
                ->setLevel($levels[mt_rand(0, count($levels) - 1)])
                ->setUser($users[mt_rand(0, count($users) - 1)])
                ->setNumberOfPerson($numberPersons[mt_rand(0, count($numberPersons) - 1)])
                ->setSport($sports[mt_rand(0, count($sports) - 1)]);

            $manager->persist($post);
        }

        $manager->flush();
    }
}
