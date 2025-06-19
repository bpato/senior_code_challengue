<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product as DoctrineProduct;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('es_ES');

        foreach (range(1, 100) as $i) {
            $product = new DoctrineProduct();
            $product->setName($faker->words(3, true));
            $product->setPrice($faker->randomFloat(2, 5, 500));

            $manager->persist($product);
        }

        $manager->flush();
    }
}
