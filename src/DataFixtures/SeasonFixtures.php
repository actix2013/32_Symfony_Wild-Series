<?php


namespace App\DataFixtures;


use App\Entity\Program;
use App\Entity\Season;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class SeasonFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture implements \Doctrine\Common\DataFixtures\DependentFixtureInterface
{
    public const MAX_SEASON_FOR_EACH_PROGRAM = 12;
    public const MIN_SEASON_FOR_EACH_PROGRAM = 2;
    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        // pour chaque programme
        for ($j = 0; $j <= ProgramFixtures::NUMBER_PROGRAM; $j++) {
            // generation de l'année de la saison 1 avec faker , ensuite plus 1 a chaque saison
            $baseYear = $faker->year;

            // pour chaque programme creation d'un nombre aléatoire de saisons
            for ($i = 0; $i < rand(SELF::MIN_SEASON_FOR_EACH_PROGRAM,SELF::MAX_SEASON_FOR_EACH_PROGRAM); $i++) {
                $season = new Season();
                // utilisation de faker pour la description
                $season->setDescription($faker->paragraph);
                // le number ne peut pas etre aleatoire sinon perte de coherence
                $season->setNumber($i+1);
                $season->setYear($baseYear);
                $manager->persist($season);
                $season->setProgram($this->getReference("program_" . $j));
                $this->addReference("season_$j" . "_" .$i, $season);
                $baseYear++;
            }
        }
        $manager->flush();// TODO: Implement load() method.
    }

}
