<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture {

    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordHasher) {
        $this->passwordEncoder = $passwordHasher;
    }

    public function load(ObjectManager $manager) {
        $userRado = new \App\Entity\User();
        $userRado->setEmail('Rado2004@wp.pl');
        $userRado->setPassword($this->passwordEncoder->hashPassword(
            $userRado,
            '13579'
        ));

        $manager->persist($userRado);

        $manager->flush();
    }

}
