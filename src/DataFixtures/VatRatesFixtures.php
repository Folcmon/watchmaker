<?php

namespace App\DataFixtures;

use App\Entity\VatRate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VatRatesFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $vatRate1 = new VatRate();
        $vatRate1->setRateName("23%");
        $vatRate1->setRateValue(23);
        $manager->persist($vatRate1);

        $vatRate2 = new VatRate();
        $vatRate2->setRateName("8%");
        $vatRate2->setRateValue(8);
        $manager->persist($vatRate2);

        $vatRate3 = new VatRate();
        $vatRate3->setRateName("5%");
        $vatRate3->setRateValue(5);
        $manager->persist($vatRate3);

        $vatRate4 = new VatRate();
        $vatRate4->setRateName("0%");
        $vatRate4->setRateValue(0);
        $manager->persist($vatRate4);

        $manager->flush();
    }
}