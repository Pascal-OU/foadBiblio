<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: LivreRepository::class)]

#[Vich\Uploadable(mapping: 'book_covers', fileNameProperty: 'couverture')]

class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $auteur = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    private ?Category $category = null;

    #[Vich\UploadableField(mapping: 'book_covers', fileNameProperty: 'couverture')]
    /* #[var File|null] */
    private ?File $couvertureFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $couvertureName;

    /**
     * @var Collection<int, Comment>
     */
    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'livre')]
    private Collection $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    // Title
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    // Auteur
    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    // User
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    // Category
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    // Couverture
    public function getCouvertureFile():?File
    {
        return $this->couvertureFile;
    }
    public function setCouvertureFile(?File $couvertureFile = null): void
    {
        $this->couvertureFile = $couvertureFile;
    }
    public function getCouvertureName(): ?string
    {
        return $this->couvertureName;
    }
    public function setCouvertureName(?string $couvertureName): void
    {
        $this->couvertureName = $couvertureName;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setLivre($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getLivre() === $this) {
                $comment->setLivre(null);
            }
        }

        return $this;
    }

}
