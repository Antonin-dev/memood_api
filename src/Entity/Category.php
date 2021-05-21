<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Meme::class, mappedBy="category", orphanRemoval=true)
     */
    private $memes;

    public function __construct()
    {
        $this->memes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Meme[]
     */
    public function getMemes(): Collection
    {
        return $this->memes;
    }

    public function addMeme(Meme $meme): self
    {
        if (!$this->memes->contains($meme)) {
            $this->memes[] = $meme;
            $meme->setCategory($this);
        }

        return $this;
    }

    public function removeMeme(Meme $meme): self
    {
        if ($this->memes->removeElement($meme)) {
            // set the owning side to null (unless already changed)
            if ($meme->getCategory() === $this) {
                $meme->setCategory(null);
            }
        }

        return $this;
    }
}
