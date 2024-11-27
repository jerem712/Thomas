<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Image;

class AppImage extends Fixture
{
    private const IMAGE_REFERENCE = "Image";
    public function load(ObjectManager $manager): void
    {
        $images = [
            "Factory_Cart.webp"
        ];

        foreach ($images as $key => $uneimage) {
            $image = new Image();
            $image->setUrl($uneimage);
            $manager->persist($image);
            $this->addReference(self::IMAGE_REFERENCE . "_" . $key, $image);
        }

        $manager->flush();
    }
}
