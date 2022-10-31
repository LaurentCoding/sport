<?php

namespace App\DataFixtures;

use App\Entity\Sport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class SportFixtures extends Fixture
{

    private Generator $faker;

    public function __construct()
    {
      $this->faker = Factory::create('fr_FR');
    }


    public function load(ObjectManager $manager): void
    {
      for ($i = 0; $i < 50; $i++){
        $sport = new Sport();
        $sport->setName($this->faker->word());

        $manager->persist($sport);
      }
       

        $manager->flush();
    }
}
