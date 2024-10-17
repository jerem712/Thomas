<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class AppUser extends Fixture
{
    private const USER_REFERENCE = "User";
    public function load(ObjectManager $manager): void
    {
        $address = $this->getReference("Address_0");

        $user = new User();
        $user->setEmail("jeremie.grunnagel3@etu.univ-lorraine.fr")
            ->setFirstname("Jeremie")
            ->setLastname("Grunnagel")
            ->setRoles(True)
            ->setPassword("password_test")
            ->setAddress($address);
        $manager->persist($user);

        $manager->flush();
    }
}
