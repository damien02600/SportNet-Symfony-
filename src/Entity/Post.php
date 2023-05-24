<?php
    /** 
     * Je créer les entité Post,City,Department et Region.
     * J'ajoute des contraintes au entité grace à Assert (composer require symfony/validator).
     * Puis je rajoute les fixtures grace à le commande "composer require --dev orm-fixtures" qui va me créer le fichier AppFixture.
    */   
namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?Sports $sport = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?City $city = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?Level $level = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?NumberOfPersons $numberOfPerson = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    private ?User $user = null;

    /** 
     * Je créer une méthode magique
     * A chaque fois que l'objet se construit, on va lui dire que  $this->createdAt est un DateTimeImmutable
    */ 

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSport(): ?Sports
    {
        return $this->sport;
    }

    public function setSport(?Sports $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getNumberOfPerson(): ?NumberOfPersons
    {
        return $this->numberOfPerson;
    }

    public function setNumberOfPerson(?NumberOfPersons $numberOfPerson): self
    {
        $this->numberOfPerson = $numberOfPerson;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
