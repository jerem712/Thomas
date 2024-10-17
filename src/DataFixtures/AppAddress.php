<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Address;

class AppAddress extends Fixture
{
    private const ADDRESS_REFERENCE = "Address";
    public function load(ObjectManager $manager): void
    {
        $biomes = [
            "Grass Fields",
            "Rocky Desert",
            "Northern Forest",
            "Dune Desert"
        ];

        foreach ($biomes as $key => $unbiome) {
            $biome = new Address();
            $biome->setBiome($unbiome);
            $biome->setCoordinateX(1);
            $biome->setCoordinateY(1);
            $manager->persist($biome);
            $this->addReference(self::ADDRESS_REFERENCE . "_" . $key, $biome);
        }

        $manager->flush();
    }
}
