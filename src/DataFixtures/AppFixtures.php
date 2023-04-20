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
use Faker\Generator;
use App\Entity\Region;
use App\Entity\Department;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{

    private Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {



        // Fixture Région
        // Je commence à remplir l'entité Region car c'est la seule qui n'a pas de clé étrangére.
        
        $region = [];
        for ($i = 0; $i < 50; $i++) {
            $region = new Region();
            $region->setName($this->faker->word())
                ->setPostalcode(mt_rand(1000, 99999));
            $regions[] = $region;

            $manager->persist($region);
        }


        // Fixture Département

        $department = [];
        for ($i = 0; $i < 50; $i++) {
            $department = new Department();
            $department->setName($this->faker->word())
                ->setCode(mt_rand(1000, 99999))
                ->setRegion($regions[mt_rand(0, count($regions) - 1)]);;
            $departments[] = $department;

            $manager->persist($department);
        }

        // Fixture Villes

        $city = [];
        for ($i = 0; $i < 50; $i++) {
            $city = new City();
            $city->setName($this->faker->word())
                ->setCode(mt_rand(1000, 99999))
                ->setDepartment($departments[mt_rand(0, count($departments) - 1)]);;
            $citys[] = $city;

            $manager->persist($city);
        }

        // Fixture Post

        for ($i = 0; $i < 50; $i++) {
            $post = new Post();
            $post->setTitle($this->faker->word())
                ->setDescription($this->faker->text(300))
                ->setCity($citys[mt_rand(0, count($citys) - 1)]);;

            $manager->persist($post);
        }


        $manager->flush();
    }
}
