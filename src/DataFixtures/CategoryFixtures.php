<?php


namespace App\DataFixtures;


use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Category;

class CategoryFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture
{
    const CATEGORIES = [
        "Action",
        "Aventure",
        "Animation",
        "Fantastique",
        "Horreur",
        "Science Fiction",
        "Space Opera",
        "Heroic Fantasy",
        "Humour",
        "Drame",
        "Reportage",
        "Anticipation",
        "Enfants",
        "Manga"
    ];

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        foreach (SELF::CATEGORIES as $key => $cathegoryName) {
            $category = new Category();
            $category->setName($cathegoryName);
            $manager->persist($category);
            $this->addReference('categorie_' . $key, $category);
        }
        $manager->flush();
    }

}
