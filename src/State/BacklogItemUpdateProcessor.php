<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\BacklogItemUpdateInput;
use App\Entity\BacklogItem;
use Doctrine\ORM\EntityManagerInterface;

class BacklogItemUpdateProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em
    )
    {}

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): BacklogItem{

        /** @var BacklogItem $item */
        $item = $context['previous_data'];

        /** @var BacklogItemUpdateInput $data */
        $item->setStatus($data->status);

        $this->em->flush();

        return $item;
    }
}
