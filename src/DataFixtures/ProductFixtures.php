<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Product;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $milk = (new Product())
            ->setTitle('Milk')
            ->setPrice('1.99')
            ->setDescription('Tasty milk');
        $manager->persist($milk);

        $bread = (new Product())
            ->setTitle('Bread')
            ->setPrice('2.15')
            ->setDescription('Black bread');
        $manager->persist($bread);

        $flour = (new Product())
            ->setTitle('Flour')
            ->setPrice('0.99')
            ->setDescription('Pretty flour');
        $manager->persist($flour);

        $manager->flush();
    }
}
