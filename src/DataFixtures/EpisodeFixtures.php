<?php


namespace App\DataFixtures;


use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle;
use Faker;

class EpisodeFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture implements \Doctrine\Common\DataFixtures\DependentFixtureInterface
{
    public const MAX_EPISODE_FOR_EACH_SEASON = 30;
    public const MIN_EPISODE_FOR_EACH_SEASON = 10;

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [Season::class];
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
        {

            $faker = Faker\Factory::create('fr_FR');
            for ($j = 0; $j <= ProgramFixtures::NUMBER_PROGRAM; $j++) {
                $program = $this->getReference("program_$j");
                $seasons = $program->getSeasons();
                for ($i = 0; $i < count($seasons); $i++) {
                    for($l=0 ; $l < rand(SELF::MIN_EPISODE_FOR_EACH_SEASON,SELF::MAX_EPISODE_FOR_EACH_SEASON);$l++) {
                        $episode = new Episode();
                        $episode->setNumber($l);
                        $episode->setTitle($faker->title);
                        $episode->setSynopsis($faker->paragraph(10,true));
                        $manager->persist($episode);
                        $episode->setSeason($this->getReference("season_$j" . "_$i"));
                        $this->addReference("episode_" . $j . "_$i" . "_$l");

                    }
                }
            }
            $manager->flush();// TODO: Implement load() method.
        }
}
