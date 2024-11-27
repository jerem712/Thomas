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
        //$image = $this->getReference("Image_0");

        $product = new Product();
        $product->setName("FICSIT Factory Cart")
            ->setPrice(10)
            ->setDescription("The one and only FICSIT Factory Cart™
Now with special - FICSIT Foundation only - Grip Wheels, for an even smoother and faster factory floor experience!")
            ->setStock(1)
            ->setStatus(ProductStatus::disponible)
            ->setCategory($category)
            ->setImage("Factory_Cart.webp");
        $manager->persist($product);
        $this->addReference(self::PRODUCT_REFERENCE . "_0", $product);

        $product = new Product();
        $product->setName("Golden Factory Cart")
            ->setPrice(50)
            ->setDescription("The one and only Golden FICSIT Factory Cart™
You have now officially ascended.
Go forth now, Master of Spaghetti, God of the Factory, Sinker of Cups, Employee of the Planet... travel in STYLE!")
            ->setStock(1)
            ->setStatus(ProductStatus::disponible)
            ->setCategory($category)
            ->setImage("Golden_Factory_Cart.png");
        $manager->persist($product);
        $this->addReference(self::PRODUCT_REFERENCE . "_1", $product);

        $product = new Product();
        $product->setName("Cyber Wagon")
            ->setPrice(20)
            ->setDescription("Absolutely indestructible.
Needs no further introduction.")
            ->setStock(1)
            ->setStatus(ProductStatus::disponible)
            ->setCategory($category)
            ->setImage("Cyber_wagon.webp");
        $manager->persist($product);
        $this->addReference(self::PRODUCT_REFERENCE . "_2", $product);

        $product = new Product();
        $product->setName("Boom Box")
            ->setPrice(3)
            ->setDescription("Boost your efficiency now, with the completely unnecessary FICSIT Boombox!
*Tapes are sold separately.")
            ->setStock(1)
            ->setStatus(ProductStatus::disponible)
            ->setCategory($category)
            ->setImage("Boom_Box.png");
        $manager->persist($product);
        $this->addReference(self::PRODUCT_REFERENCE . "_3", $product);
        
        $product = new Product();
        $product->setName("Adequate Pioneering")
            ->setPrice(25)
            ->setDescription("The statue of the Running Character.")
            ->setStock(1)
            ->setStatus(ProductStatus::disponible)
            ->setCategory($category)
            ->setImage("Statue_1.png");
        $manager->persist($product);
        $this->addReference(self::PRODUCT_REFERENCE . "_4", $product);

        $category = $this->getReference("Category_1");
        //$image = $this->getReference("Image_0");

        $product = new Product();
        $product->setName("Conveyor Wall Mount")
            ->setPrice(1)
            ->setDescription("Attaches to Walls.
Useful for routing Conveyor Belts more precisely and over long distances.")
            ->setStock(1)
            ->setStatus(ProductStatus::disponible)
            ->setCategory($category)
            ->setImage("Conveyor_Wall_Mount.png");
        $manager->persist($product);
        $this->addReference(self::PRODUCT_REFERENCE . "_5", $product);

        $product = new Product();
        $product->setName("Conveyor Ceiling Mount")
            ->setPrice(1)
            ->setDescription("Attaches to ceilings and other ceiling mounts.
Useful for routing Conveyor Belts more precisely and over long distances.")
            ->setStock(1)
            ->setStatus(ProductStatus::disponible)
            ->setCategory($category)
            ->setImage("Conveyor_Ceiling_Mount.png");
        $manager->persist($product);
        $this->addReference(self::PRODUCT_REFERENCE . "_6", $product);

        $manager->flush();
    }
}
