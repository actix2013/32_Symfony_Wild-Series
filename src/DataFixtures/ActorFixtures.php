<?php


namespace App\DataFixtures;


use App\Entity\Actor;
use App\Entity\Program;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ActorFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture implements DependentFixtureInterface
{



    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $k = 0;
        for ($i = 0; $i < 50; $i++) {
            $actor = new Actor();
            $faker = Faker\Factory::create('fr_FR');
            $fonctionName = "setName";
            $actor->{$fonctionName}($faker->name);
            $manager->persist($actor);
            for ($j = 0; $j < rand(0, ProgramFixtures::NUMBER_PROGRAM); $j++) {
                $actor->addProgram($this->getReference("program_" . rand(0, ProgramFixtures::NUMBER_PROGRAM)));
            }
            $this->addReference("actor_" . $k, $actor);

            $k++;
        }
        $manager->flush();// TODO: Implement load() method.
        /*$i = 0;
        foreach (SELF::ACTORS as $name => $progs ) {
            $actor = new Actor();
            $fonctionName = "setName";
            $actor->{$fonctionName}($name);
            $manager->persist($actor);
            $list = $progs["programs"];
            foreach ( $list as $value) {
                $value;
                $actor->addProgram($this->getReference($value));
            }
            $this->addReference("actor_".$i,$actor);

            $i++;
        }
        $manager->flush();// TODO: Implement load() method.*/
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }


}
