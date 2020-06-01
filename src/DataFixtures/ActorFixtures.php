<?php


namespace App\DataFixtures;


use App\Entity\Actor;
use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ActorFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture implements DependentFixtureInterface
{

    const ACTORS  = [
        "Andrew LINCOLN" => [
            "programs" => ["program_0","program_5"]
        ],
        "Norman REEDUS" => [
            "programs" => ["program_0"]
        ],
        "Lauren COHAN" => [
            "programs" => ["program_0"]
        ],
        "Danai GUIR" => [
            "programs" => ["program_0"]
        ],
    ];

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $k = 0;
        $slugify = new Slugify();
        // creation manuelle des acteurs
        foreach (SELF::ACTORS as $name => $progs) {
            $actor = new Actor();
            $fonctionName = "setName";
            $actor->{$fonctionName}($name);
            $actor->setSlug($slugify->generate($actor->getName()));
            $manager->persist($actor);
            $list = $progs["programs"];
            foreach ($list as $value) {
                $value;
                $actor->addProgram($this->getReference($value));
            }
            $this->addReference("actor_" . $k, $actor);
            $k++;
        }

        // creation des acteur a l'aide de faker
        for ($i = 5; $i < 55; $i++) {
            $actor = new Actor();
            $faker = Faker\Factory::create('fr_FR');
            $fonctionName = "setName";
            $actor->{$fonctionName}($faker->name);
            $actor->setSlug($slugify->generate($actor->getName()));
            $manager->persist($actor);
            for ($j = 0; $j < rand(0, ProgramFixtures::NUMBER_PROGRAM); $j++) {
                $actor->addProgram($this->getReference("program_" . rand(0, ProgramFixtures::NUMBER_PROGRAM)));
            }
            $this->addReference("actor_" . $k, $actor);
            $k++;
        }
        $manager->flush();// TODO: Implement load() method.
        /*$i = 0;

        $manager->flush();// TODO: Implement load() method.*/
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }


}
