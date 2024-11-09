<?php

namespace App\DataFixtures;

use App\Entity\Storage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class StorageFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct()
    {

    }

    public function load(ObjectManager $manager): void
    {
        $casioWatchStrap = new Storage();
        $casioWatchStrap->setName("ORYGINALNY PASEK CASIO AE-1000W-4A Czerwony");
        $casioWatchStrap->setQuantity(10);
        $casioWatchStrap->setAlarmQuantity(2);
        $casioWatchStrap->setPrice(34.15);
        $casioWatchStrap->setVatRate($this->getReference(VatRatesFixtures::VAT_RATE_23_REFERENCE));
        $casioWatchStrap->setMargin(0);
        $manager->persist($casioWatchStrap);

        $casioWatchStrap2 = new Storage();
        $casioWatchStrap2->setName("ORYGINALNY PASEK CASIO AE-1000W-4A Czarny");
        $casioWatchStrap2->setQuantity(1);
        $casioWatchStrap2->setAlarmQuantity(2);
        $casioWatchStrap2->setPrice(45.15);
        $casioWatchStrap2->setVatRate($this->getReference(VatRatesFixtures::VAT_RATE_23_REFERENCE));
        $casioWatchStrap2->setMargin(0);
        $manager->persist($casioWatchStrap2);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            VatRatesFixtures::class,
        ];
    }

}
