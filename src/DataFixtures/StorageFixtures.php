<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StorageFixtures extends Fixture
{

    public function __construct()
    {

    }

    public function load(ObjectManager $manager)
    {
        $casioWatchStrap = new \App\Entity\Storage();
        $casioWatchStrap->setName("ORYGINALNY PASEK CASIO AE-1000W-4A CZERWONY");
        $casioWatchStrap->setQunatity(10);
        $casioWatchStrap->setAlarmQuantity(2);
        $casioWatchStrap->setPrice(34.15);
        $casioWatchStrap->setVat(23);
        $casioWatchStrap->setMargin(20);
        $manager->persist($casioWatchStrap);

        $casioWatchStrap2 = new \App\Entity\Storage();
        $casioWatchStrap2->setName("ORYGINALNY PASEK CASIO AE-1000W-4A CZERWONY");
        $casioWatchStrap2->setQunatity(1);
        $casioWatchStrap2->setAlarmQuantity(2);
        $casioWatchStrap2->setPrice(45,12);
        $casioWatchStrap2->setVat(23);
        $casioWatchStrap2->setMargin(20);
        $manager->persist($casioWatchStrap2);

        $manager->flush();
    }

}