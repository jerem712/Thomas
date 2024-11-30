<?php

namespace App\DataFixtures;

use App\Entity\OrderItem;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppOrderItem extends Fixture implements DependentFixtureInterface
{
    private const ORDERITEM_REFERENCE = "OrderItem";
    public function load(ObjectManager $manager): void
    {
        

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AppOrder::class,
        ];
    }
}
