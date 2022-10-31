<?php

namespace App\DataFixtures;

use App\Entity\Annee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AnneeFixtures extends Fixture
{

  private Generator $faker;

  public function __construct()
  {
    $this->faker = Factory::create('fr_FR');
  }

    public function load(ObjectManager $manager): void
    {
      for ($i = 0; $i < 12; $i++){
        $annee = new Annee();
        $annee->setYear($this->faker->randomNumber(4, true));

        $manager->persist($annee);
      }

        $manager->flush();
    }
}
