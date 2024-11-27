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
            ->setImage("https://satisfactory.wiki.gg/images/0/00/Factory_Cart.png");
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
            ->setImage("https://satisfactory.wiki.gg/images/d/d5/Golden_Factory_Cart.png");
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
            ->setImage("https://satisfactory.wiki.gg/images/thumb/5/53/Cyber_Wagon.png/300px-Cyber_Wagon.png");
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
            ->setImage("https://satisfactory.wiki.gg/images/7/7a/Boom_Box.png");
        $manager->persist($product);
        $this->addReference(self::PRODUCT_REFERENCE . "_3", $product);
        
        $product = new Product();
        $product->setName("Absolute FICSIT Boombox Tape")
            ->setPrice(1)
            ->setDescription("Boom Box tape No1")
            ->setStock(1)
            ->setStatus(ProductStatus::disponible)
            ->setCategory($category)
            ->setImage("https://i.namu.wiki/i/4z3G8wnskH2X3xph3CooigNakzU67M6DM6IWwbF9V-DxquLhP9RpOwU3qTpW3K0E7iP7gFC-5pFvojLVD1i3Uw.webp");
        $manager->persist($product);
        $this->addReference(self::PRODUCT_REFERENCE . "_4", $product);

        $product = new Product();
        $product->setName("Joel Syntholm Boombox Tape")
            ->setPrice(1)
            ->setDescription("Boom Box tape No2")
            ->setStock(1)
            ->setStatus(ProductStatus::disponible)
            ->setCategory($category)
            ->setImage("https://i.namu.wiki/i/kDLTbrdYzGE6mGWsQuhzy8PCAeEY1ViD1agbkaJS7enmyu9TkVua6DgaOLFPNwBXLL-GjuWujXRKPa6EltEM3vomAbO_HKM33oUNkYUR0wcceUx4-KC7opOvRjzQg08pd_ATKdt-eJOi1oKbICg9SQ.webp");
        $manager->persist($product);
        $this->addReference(self::PRODUCT_REFERENCE . "_5", $product);

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
            ->setImage("https://satisfactory.wiki.gg/images/thumb/f/f7/Conveyor_Wall_Mount.png/300px-Conveyor_Wall_Mount.png");
        $manager->persist($product);
        $this->addReference(self::PRODUCT_REFERENCE . "_6", $product);

        $product = new Product();
        $product->setName("Conveyor Ceiling Mount")
            ->setPrice(1)
            ->setDescription("Attaches to ceilings and other ceiling mounts.
Useful for routing Conveyor Belts more precisely and over long distances.")
            ->setStock(1)
            ->setStatus(ProductStatus::disponible)
            ->setCategory($category)
            ->setImage("https://satisfactory.wiki.gg/images/thumb/1/1c/Conveyor_Ceiling_Mount.png/300px-Conveyor_Ceiling_Mount.png");
        $manager->persist($product);
        $this->addReference(self::PRODUCT_REFERENCE . "_7", $product);

        $product = new Product();
        $product->setName("Conveyor Floor Mount")
            ->setPrice(1)
            ->setDescription("Attaches to Foundations, allowing Conveyor Lifts to pass through.")
            ->setStock(1)
            ->setStatus(ProductStatus::disponible)
            ->setCategory($category)
            ->setImage("https://satisfactory.wiki.gg/images/thumb/a/a4/Conveyor_Lift_Floor_Hole.png/300px-Conveyor_Lift_Floor_Hole.png");
        $manager->persist($product);
        $this->addReference(self::PRODUCT_REFERENCE . "_8", $product);

        $manager->flush();
    }
}
