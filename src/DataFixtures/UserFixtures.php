<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture {

    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager) {
        $userRado = new \App\Entity\User();
        $userRado->setEmail('Rado2004@wp.pl');
        $userRado->setPassword($this->passwordEncoder->encodePassword(
            $userRado,
            '13579'
        ));

        $manager->persist($userRado);

        $manager->flush();
    }

}
