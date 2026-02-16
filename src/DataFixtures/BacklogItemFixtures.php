<?php

namespace App\DataFixtures;

use App\Entity\BacklogItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BacklogItemFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $items = [
            ['movie', 'Matrix', 'completed', null],
            ['series', 'Breaking Bad', 'in_progress', 3],
            ['game', 'Zelda', 'pending', null]
        ];

        foreach ($items as [$type, $title, $status, $progress]){
            $item = new BacklogItem();
            $item->setType($type);
            $item->setTitle($title);
            $item->setStatus($status);
            $item->setProgress($progress);

            $manager->persist($item);
        }

        $manager->flush();
    }
}
