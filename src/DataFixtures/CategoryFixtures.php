<?php


namespace App\DataFixtures;


use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Category;

class CategoryFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture
{

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $cathegory = new Category();
        $cathegory->setName("Fixtures");
        $manager->persist($cathegory);
        $manager->flush();
    }

}
