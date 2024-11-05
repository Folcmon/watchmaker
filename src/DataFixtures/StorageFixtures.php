<?php

namespace App\DataFixtures;

use App\Entity\Storage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StorageFixtures extends Fixture
{

    public function __construct()
    {

    }

    public function load(ObjectManager $manager): void
    {
        $casioWatchStrap = new Storage();
        $casioWatchStrap->setName("ORYGINALNY PASEK CASIO AE-1000W-4A CZERWONY");
        $casioWatchStrap->setQuantity(10);
        $casioWatchStrap->setAlarmQuantity(2);
        $casioWatchStrap->setPrice(34.15);
        $casioWatchStrap->setVat(23);
        $casioWatchStrap->setMargin(20);
        $manager->persist($casioWatchStrap);

        $casioWatchStrap2 = new Storage();
        $casioWatchStrap2->setName("ORYGINALNY PASEK CASIO AE-1000W-4A CZERWONY");
        $casioWatchStrap2->setQuantity(1);
        $casioWatchStrap2->setAlarmQuantity(2);
        $casioWatchStrap2->setPrice(45.15);
        $casioWatchStrap2->setVat(23);
        $casioWatchStrap2->setMargin(20);
        $manager->persist($casioWatchStrap2);

        $manager->flush();
    }

}
