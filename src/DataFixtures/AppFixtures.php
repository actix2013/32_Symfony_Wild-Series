<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Actor;
use App\Entity\Program;
use App\Entity\Category;
use App\Service\Slugify;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class AppFixtures extends Fixture
{
    const REF_PREFIX_CAT="category_";
    const REF_PREFIX_PRG = "program_";

    public function load(\Doctrine\Persistence\ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 1000; $i++) {
            $category = new Category();
            $category->setName($faker->word);
            $manager->persist($category);
            $this->addReference(SELF::REF_PREFIX_CAT . $i, $category);

            $program = new Program();
            $program->setTitle($faker->sentence(4, true));
            $program->setSummary($faker->text(100));
            $program->setCategory($this->getReference(SELF::REF_PREFIX_CAT . $i));
            $program->setPoster($faker->imageUrl());
            //$program->setCountry($faker->country);
            //$program->setYear($faker->year($max = 'now'));
            $this->addReference(SELF::REF_PREFIX_PRG . $i, $program);
            $manager->persist($program);

            for ($j = 1; $j <= 5; $j++) {
                $actor = new Actor();
                $actor->setName($faker->firstName . " " . $faker->lastName);
                //$actor->setBirthday($faker->date($format = 'Y-m-d', $max = 'now'));
                $actor->addProgram($this->getReference(SELF::REF_PREFIX_PRG . $i));
                $manager->persist($actor);
            }

        }

        $manager->flush();
    }
}
