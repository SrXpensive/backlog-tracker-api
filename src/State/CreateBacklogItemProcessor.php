<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\BacklogItem;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class CreateBacklogItemProcessor implements ProcessorInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private Security $security
    )
    {}

    public function process(
        mixed $data,
        Operation $operation,
        array $uriVariables = [],
        array $context = []
    ): BacklogItem{
        $user = $this->security->getUser();

        if(!$user){
            throw new \Exception("User not authenticated");
        }

        $data->setUser($user);
        $this->em->persist($data);
        $this->em->flush();

        return $data;
    }
}
