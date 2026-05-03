<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\BacklogItem;
use Doctrine\ORM\EntityManagerInterface;

class CompleteBacklogItemProcessor implements ProcessorInterface
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

        $data->setStatus('completed');
        $this->em->flush();
        return $data;
    }
}
