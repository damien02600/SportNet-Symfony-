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
use App\Entity\Sports;
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

        // Fixture sports

        $sport = [];
        for ($i = 0; $i < 50; $i++) {
            $sport = new Sports();
            $sport->setName($this->faker->word());
            $sports[] = $sport;

            $manager->persist($sport);
        }



        // Fixture Post

        for ($i = 0; $i < 50; $i++) {
            $post = new Post();
            $post->setTitle($this->faker->word())
                ->setDescription($this->faker->text(300))
                ->setSport($sports[mt_rand(0, count($sports) - 1)]);

            $manager->persist($post);
        }





        $manager->flush();
    }
}
