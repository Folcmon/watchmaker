<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        // Create client fixtures based on the Client entity
        $client1 = new Client();
        $client1->setName("Jan Kowalski");
        $client1->setEmail("jan.kowalski@it.pl");
        $client1->setTelephone("123456789");
        $manager->persist($client1);

        $client2 = new Client();
        $client2->setName("Adam Nowak");
        $client2->setEmail("adam.nowak@it.pl");
        $client2->setTelephone("987654321");
        $manager->persist($client2);

        $client3 = new Client();
        $client3->setName("Krzysztof Krawczyk");
        $client3->setEmail("krzysztof.krawczyk@it.pl");
        $client3->setTelephone("123456789");
        $manager->persist($client3);

        $manager->flush();
    }
}