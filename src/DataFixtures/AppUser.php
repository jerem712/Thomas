<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppUser extends Fixture
{
    private const USER_REFERENCE = "User";
    private $userPasswordHasherInterface;

    public function __construct (UserPasswordHasherInterface $userPasswordHasherInterface) 
    {
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
    }
    public function load(ObjectManager $manager): void
    {
        $address = $this->getReference("Address_0");

        $user = new User();
        $user->setEmail("jeremie.grunnagel3@etu.univ-lorraine.fr")
            ->setFirstName("Jeremie")
            ->setLastName("Grunnagel")
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword($this->userPasswordHasherInterface->hashPassword(
                $user, "password"))
            ->setVerified(True)
            ->setAdress($address);
        $manager->persist($user);
        $this->addReference(self::USER_REFERENCE . "_0", $user);

        $manager->flush();
    }
}
