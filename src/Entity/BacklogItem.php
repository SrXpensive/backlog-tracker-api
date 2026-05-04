<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BacklogItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Attribute\Groups;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use App\State\CompleteBacklogItemProcessor;
use App\Dto\BacklogItemUpdateInput;
use App\State\BacklogItemUpdateProcessor;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;

#[ORM\Entity(repositoryClass: BacklogItemRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['backlog:list']]
        ),
        new Get(
            normalizationContext: ['groups' => ['backlog:detail']]
        ),
        new Post(
            denormalizationContext: ['groups' => ['backlog:write']]
        ),
        new Patch(
            input: BacklogItemUpdateInput::class,
            processor: BacklogItemUpdateProcessor::class
        )
    ]
)]
#[ApiFilter(SearchFilter::class, properties: [
    'status' => 'exact',
    'title' => 'partial',
    'user' => 'exact'
])]
class BacklogItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['backlog:list', 'backlog:detail'])]
    private ?int $id = null;

    #[Assert\Choice(choices:['movie','book','game'], message: "El tipo debe ser 'movie', 'book' o 'game'")]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[Assert\NotBlank(message: 'El título no puede estar vacío.')]
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['backlog:list', 'backlog:detail', 'backlog:write'])]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $status = null;

    #[ORM\Column(nullable: true)]
    private ?int $progress = null;

    #[ORM\ManyToOne(inversedBy: 'backlogItems')]
    #[Groups(['backlog:detail'])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getProgress(): ?int
    {
        return $this->progress;
    }

    public function setProgress(?int $progress): static
    {
        $this->progress = $progress;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
