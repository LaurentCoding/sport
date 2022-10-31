<?php

namespace App\DataFixtures;

use App\Entity\Mois;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class MoisFixtures extends Fixture
{

    private Generator $faker;

    public function __construct()
    {
      $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        
        for ($i = 0; $i < 12; $i++){
          $mois = new Mois();
          $mois->setName($this->faker->word());
  
          $manager->persist($mois);
        }
        $manager->flush();
    }
}
