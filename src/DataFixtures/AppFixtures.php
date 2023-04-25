<?php

/*
La commande pour les fixture (composer require --dev orm-fixtures).
Je rajoute FakerPHP qui me permet d'avoir des nom plus crédible (composer require fakerphp/faker).
Je commence à remplir l'entité Region car c'est la seule qui n'a pas de clé étrangére.
*/


namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Post;
use Faker\Generator;
use App\Entity\Level;
use App\Entity\Sports;
use App\Entity\NumberOfPersons;
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

        // Fixture level

        $level = [];
        for ($i = 0; $i < 3; $i++) {
            $level = new Level();
            $level->setName($this->faker->word());
            $levels[] = $level;

            $manager->persist($level);
        }

        // Fixture numberPerson

        $numberPerson = [];
        for ($i = 0; $i < 15; $i++) {
            $numberPerson = new NumberOfPersons();
            $numberPerson
            ->setNumberPerson(mt_rand(1, 15));
            $numberPersons[] = $numberPerson;

            $manager->persist($numberPerson);
        }

        // Fixture Post

        for ($i = 0; $i < 50; $i++) {
            $post = new Post();
            $post->setTitle($this->faker->word())
                ->setDescription($this->faker->text(300))
                ->setSport($sports[mt_rand(0, count($sports) - 1)])
                ->setLevel($levels[mt_rand(0, count($levels) - 1)])
                ->setNumberOfPerson($numberPersons[mt_rand(0, count($numberPersons) - 1)]);

            $manager->persist($post);
        }

        $manager->flush();
    }
}
