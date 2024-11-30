<?php

namespace App\DataFixtures;

use App\Entity\Order;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppOrder extends Fixture implements DependentFixtureInterface
{
    private const ORDER_REFERENCE = "Order";
    public function load(ObjectManager $manager): void
    {
        

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AppProduct::class,
        ];
    }
}
