<?php


namespace App\DataFixtures;


use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Program;


class ProgramFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture implements DependentFixtureInterface
{

    const PROGRAMS = [
        'The Walking Dead' => [
            'summary' => 'Le policier Rick Grimes se réveille après un long coma. Il découvre avec effarement que le monde, ravagé par une épidémie, est envahi par les morts-vivants.',
            "poster" => "https://m.media-amazon.com/images/M/MV5BYTUwOTM3ZGUtMDZiNy00M2I3LWI1ZWEtYzhhNGMyZjI3MjBmXkEyXkFqcGdeQXVyMTkxNjUyNQ@@._V1_SY1000_CR0,0,666,1000_AL_.jpg",
            'category' => 'categorie_4',
        ],


        'The Haunting Of Hill House' => [
            'summary' => 'Plusieurs frères et sœurs qui, enfants, ont grandi dans la demeure qui allait devenir la maison hantée la plus célèbre des États-Unis, sont contraints de se réunir pour finalement affronter les fantômes de leur passé.',
            "poster" => "https://m.media-amazon.com/images/M/MV5BMTU4NzA4MDEwNF5BMl5BanBnXkFtZTgwMTQxODYzNjM@._V1_SY1000_CR0,0,674,1000_AL_.jpg",
            'category' => 'categorie_4',
        ],
        'American Horror Story' => [
            'summary' => 'A chaque saison, son histoire. American Horror Story nous embarque dans des récits à la fois poignants et cauchemardesques, mêlant la peur, le gore et le politiquement correct.',
            "poster" => "http://fr.web.img6.acsta.net/r_1920_1080/pictures/18/10/30/17/07/0996605.jpg",
            'category' => 'categorie_4',
        ],
        'Love Death And Robots' => [
            'summary' => 'Un yaourt susceptible, des soldats lycanthropes, des robots déchaînés, des monstres-poubelles, des chasseurs de primes cyborgs, des araignées extraterrestres et des démons assoiffés de sang : tout ce beau monde est réuni dans 18 courts métrages animés déconseillés aux âmes sensibles.',
            "poster" => "http://fr.web.img5.acsta.net/r_1920_1080/pictures/19/02/15/09/58/3274407.jpg",
            'category' => 'categorie_4',
        ],
        'Penny Dreadful' => [
            'summary' => 'Dans le Londres ancien, Vanessa Ives, une jeune femme puissante aux pouvoirs hypnotiques, allie ses forces à celles de Ethan, un garçon rebelle et violent aux allures de cowboy, et de Sir Malcolm, un vieil homme riche aux ressources inépuisables. Ensemble, ils combattent un ennemi inconnu, presque invisible, qui ne semble pas humain et qui massacre la population.',
            "poster" => "http://fr.web.img2.acsta.net/r_1920_1080/pictures/16/02/26/17/48/506664.jpg",
            'category' => 'categorie_4',
        ],
        'Fear The Walking Dead' => [
            'summary' => 'La série se déroule au tout début de l épidémie relatée dans la série mère The Walking Dead et se passe dans la ville de Los Angeles, et non à Atlanta. Madison est conseillère dans un lycée de Los Angeles. Depuis la mort de son mari, elle élève seule ses deux enfants : Alicia, excellente élève qui découvre les premiers émois amoureux, et son grand frère Nick qui a quitté la fac et a sombré dans la drogue.',
            "poster" => "http://fr.web.img5.acsta.net/r_1920_1080/pictures/19/07/01/00/40/3357384.jpg",
            'category' => 'categorie_4',
        ],
    ];


    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {

        $i=0;
        foreach (SELF::PROGRAMS as $title => $data) {
            $program = new Program();
            $fonctionName = "setTitle";
            $program->{$fonctionName}($title);
            $fonctionName = "setSummary";
            $program->{$fonctionName}($data["summary"]);
            $fonctionName = "setPoster";
            $program->{$fonctionName}($data["poster"]);
            $manager->persist($program);
            $program->setCategory($this->getReference($data["category"]));
            $this->addReference("program_" . $i, $program);
            $i++;
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }


}
