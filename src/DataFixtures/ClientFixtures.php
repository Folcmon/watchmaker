<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{
    const CLIENT_1_REFERENCE = 'client-1';
    const CLIENT_2_REFERENCE = 'client-2';
    const CLIENT_3_REFERENCE = 'client-3';

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
        $client3->setTelephone("123456788");
        $manager->persist($client3);

        $manager->flush();

        $this->addReference(self::CLIENT_1_REFERENCE, $client1);
        $this->addReference(self::CLIENT_2_REFERENCE, $client2);
        $this->addReference(self::CLIENT_3_REFERENCE, $client3);
    }
}