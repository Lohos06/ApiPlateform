<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\GenreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: GenreRepository::class)]
#[ApiResource(
    normalizationContext: ['groups'=> ['genre:lire']],
    denormalizationContext: ['groups'=> ['genre:ecrire']],
)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['genre:lire'])]
    private ?int $id = null;

    #[ORM\Column(length: 255 , unique:true)]
    #[Groups(['genre:lire','genre:ecrire','livre:lire'])]
    private ?string $nom = null;

    /**
     * @var Collection<int, Livre>
     */
    #[Groups(['genre:lire','genre:ecrire','livre:lire'])]

    #[ORM\ManyToMany(targetEntity: Livre::class, mappedBy: 'genre')]
    private Collection $livres;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(Livre $livre): static
    {
        if (!$this->livres->contains($livre)) {
            $this->livres->add($livre);
            $livre->addGenre($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): static
    {
        if ($this->livres->removeElement($livre)) {
            $livre->removeGenre($this);
        }

        return $this;
    }
}
