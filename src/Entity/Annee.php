<?php

namespace App\Entity;

use App\Repository\AnneeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnneeRepository::class)]
#[UniqueEntity('year')]
class Annee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 4)]
    #[Assert\Positive()]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 4)]
    private ?int $year = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of year
     */ 
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set the value of year
     *
     * @return  self
     */ 
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }
}
