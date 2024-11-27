<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Category;

class AppCategory extends Fixture
{
    private const CATEGORY_REFERENCE = "Category";
    public function load(ObjectManager $manager): void
    {
        $categories = [
            "FICSIT Specials",
            "Management",
            "Organization",
            "Customizer",
            "Foundations",
            "Walls",
            "Architecture",
            "Equipment",
            "Parts"
        ];

        foreach ($categories as $key => $unecategory) {
            $category = new Category();
            $category->setName($unecategory);
            $manager->persist($category);
            $this->addReference(self::CATEGORY_REFERENCE . "_" . $key, $category);
        }
        $manager->flush();
    }
}
