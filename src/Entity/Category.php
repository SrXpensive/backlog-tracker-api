<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ApiResource]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['backlog:detail'])]
    private ?string $name = null;

    /**
     * @var Collection<int, BacklogItem>
     */
    #[ORM\OneToMany(targetEntity: BacklogItem::class, mappedBy: 'category')]
    private Collection $backlogItems;

    public function __construct()
    {
        $this->backlogItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, BacklogItem>
     */
    public function getBacklogItems(): Collection
    {
        return $this->backlogItems;
    }

    public function addBacklogItem(BacklogItem $backlogItem): static
    {
        if (!$this->backlogItems->contains($backlogItem)) {
            $this->backlogItems->add($backlogItem);
            $backlogItem->setCategory($this);
        }

        return $this;
    }

    public function removeBacklogItem(BacklogItem $backlogItem): static
    {
        if ($this->backlogItems->removeElement($backlogItem)) {
            // set the owning side to null (unless already changed)
            if ($backlogItem->getCategory() === $this) {
                $backlogItem->setCategory(null);
            }
        }

        return $this;
    }
}
