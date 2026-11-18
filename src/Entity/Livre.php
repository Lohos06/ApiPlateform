<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Contraints as Assert;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=> ['livre:lire']],
    denormalizationContext: ['groups'=> ['livre:ecrire']],
)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['livre:lire'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['livre:lire', 'lire:ecrire'])]
    #[Assert\NotBlank]
    #[Assert\length(max: 255)]
    private ?string $titre = null;

    #[ORM\Column(nullable: true)]

    #[Groups(['livre:lire', 'lire:ecrire'])]
    #[Assert\Range(min:1400,max:2100)]
    private ?int $anneePublication = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['livre:lire', 'lire:ecrire'])]
    #[Assert\Positive]
    private ?int $nbPages = null;

    #[ORM\Column(length: 50, unique:true, nullable: true)]
    private ?string $openLibraryId = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['livre:lire', 'lire:ecrire'])]
    private ?Auteur $auteur = null;

    /**
     * @var Collection<int, Genre>
     */
    #[ORM\ManyToMany(targetEntity: Genre::class, inversedBy: 'livres')]
    #[Groups(['livre:lire', 'lire:ecrire'])]
    private Collection $genre;

    public function __construct()
    {
        $this->genre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAnneePublication(): ?int
    {
        return $this->anneePublication;
    }

    public function setAnneePublication(?int $anneePublication): static
    {
        $this->anneePublication = $anneePublication;

        return $this;
    }

    public function getNbPages(): ?int
    {
        return $this->nbPages;
    }

    public function setNbPages(?int $nbPages): static
    {
        $this->nbPages = $nbPages;

        return $this;
    }

    public function getOpenLibraryId(): ?string
    {
        return $this->openLibraryId;
    }

    public function setOpenLibraryId(?string $openLibraryId): static
    {
        $this->openLibraryId = $openLibraryId;

        return $this;
    }

    public function getAuteur(): ?Auteur
    {
        return $this->auteur;
    }

    public function setAuteur(?Auteur $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenre(): Collection
    {
        return $this->genre;
    }

    public function addGenre(Genre $genre): static
    {
        if (!$this->genre->contains($genre)) {
            $this->genre->add($genre);
        }

        return $this;
    }

    public function removeGenre(Genre $genre): static
    {
        $this->genre->removeElement($genre);

        return $this;
    }
}
