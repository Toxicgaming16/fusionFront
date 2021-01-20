<?php

namespace App\Entity;

use App\Repository\ListingCategoryTranslationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListingCategoryTranslationRepository::class)
 */
class ListingCategoryTranslation
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
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $locale;

    /**
     * @ORM\OneToMany(targetEntity=ListingCategory::class, mappedBy="ListingCategoryTranslation")
     */
    private $translatable_id;

    public function __construct()
    {
        $this->translatable_id = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return Collection|ListingCategory[]
     */
    public function getTranslatableId(): Collection
    {
        return $this->translatable_id;
    }

    public function addTranslatableId(ListingCategory $translatableId): self
    {
        if (!$this->translatable_id->contains($translatableId)) {
            $this->translatable_id[] = $translatableId;
            $translatableId->setListingCategoryTranslation($this);
        }

        return $this;
    }

    public function removeTranslatableId(ListingCategory $translatableId): self
    {
        if ($this->translatable_id->removeElement($translatableId)) {
            // set the owning side to null (unless already changed)
            if ($translatableId->getListingCategoryTranslation() === $this) {
                $translatableId->setListingCategoryTranslation(null);
            }
        }

        return $this;
    }
}
