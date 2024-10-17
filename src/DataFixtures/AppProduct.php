<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Product;
use App\Enum\ProductStatus;

class AppProduct extends Fixture
{
    private const PRODUCT_REFERENCE = "Product";
    public function load(ObjectManager $manager): void
    {
        $category = $this->getReference("Category_0");
        $image = $this->getReference("Image_0");

        $product = new Product();
        $product->setName("FICSIT Factory Cart")
            ->setPrice(10)
            ->setDescription("The one and only FICSIT Factory Cart™
Now with special - FICSIT Foundation only - Grip Wheels, for an even smoother and faster factory floor experience!")
            ->setStock(1)
            ->setStatus(ProductStatus::disponible)
            ->setCategory($category)
            ->setImage($image);
        $manager->persist($product);

        $manager->flush();
    }
}
