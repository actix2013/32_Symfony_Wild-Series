<?php


namespace App\Controller;

use App\Entity\Program;

use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * Class WildController !
 *
 * @package App\Controller
 * @Route("/wild", name="wild_")
 */
class WildController extends AbstractController
{
    /**
     * utiliser pour les card bootstap qui sont numerotées.
     */
    CONST  NUMBERS = array(
            1 => "One",
            2 => "Two",
            3 => "Three",
            4 => "four",
            5 => "five",
            6 => "six",
            7 => "seven",
            8 => "eight",
            9 => "nine",
            10 => "ten",
            11 => "eleven",
            12 => "twelve",
            13 => "thirteen",
            14 => "fourteen",
            15 => "fifteen",
            16 => "sixteen",
            17 => "seventeen",
            18 => "eighteen",
            19 => "nineteen"
        );


    /**
     * @Route("/", name="index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(): Response
    {

        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository(Program::class);
        $programs = $repository->findAll();

        if (!$programs) {
           throw $this->createNotFoundException("No program found in program's table");
        }
       return $this->render('wild/index.html.twig', ['website' => 'Wild Séries', "programs" => $programs]);
        //return new Response('<html><body>Wild Series Index</body></html>');
    }


    /**
     * @Route("/episode/{id<[0-9]{1,5}>}", name="show_episode")
     */
    public function showEpisode(Episode $episode): Response
    {
        if (!$episode) {
            $message = "Aucun episode ne corespond a votre demande.";
            $function = __FUNCTION__;
            return $this->goTo404($message, $function, true);
        }
        $season = $episode->getSeason();
        $program = $season->getProgram();

        //var_dump($program);
        return $this->render('wild/episode.html.twig', ['episode' => $episode,"season" => $season, "program" =>$program]);

    }

    /**
     * @Route("/show/{slug<^[a-zA-Z0-9.-]*$>}", name="show")
     */
    public function show(string $slug): Response
    {

        if (!$slug) {
                $message = "Aucune série sélectionnée, veuillez choisir une série !";
                $function = __FUNCTION__;
                return $this->goTo404($message,$function,true);
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$program) {
            $message = "La serie [ $slug ] n'a pas été trouvée dans la database.";
            $function = __FUNCTION__;
            return $this->goTo404($message, $function);
        }
        //var_dump($program);
        return $this->render('wild/show.html.twig', [
            'program' => $program,
            'slug' => $slug,
        ]);
        return $this->render('wild/show.html.twig', ['page' => $slug]);
    }

    /**
     * @Route("/category/{categoryName}", name="category")
     */
    public function showByCategory(string $categoryName): Response
    {

        if (!$categoryName) {
            throw $this
                ->createNotFoundException('No cathegory has been sent to find this category in category\'s table.');
        }

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy([
                'name' => mb_strtolower($categoryName)
            ]);
        if (!$category) {
            throw $this->createNotFoundException(
                'No program with ' . $categoryName . ' title, found in program\'s table.'
            );
        }

        //<editor-fold desc="Methode  pour lire les objets via findby">
        $programsRepository = null;
        $programsRepository = $this->getDoctrine()
            ->getRepository(Program::class);
        $programsByFindBy = $programsRepository->findBy(["category" => $category],["id" => "DESC"],3);
        //</editor-fold>

        //<editor-fold desc="Methode  pour lire les objets via query symfony">
        $programsRepository = null;
        $programsRepository = $this->getDoctrine()
            ->getRepository(Program::class);
        $query = $programsRepository->createQueryBuilder('p')
            ->where('p.category = :cat')
            ->setParameter('cat', $category)
            ->orderBy('p.title', 'ASC')
            ->getQuery();
        $programs = $query->setMaxResults(3)->getResult();
        //</editor-fold>


        if (!$programsByFindBy) {
            throw $this->createNotFoundException(
                "No program find for category $category->getName()"
            );
        }

        return $this->render('wild/category.html.twig', [
            'categoryName' => $category->getName(),
            "programs" => $programsByFindBy,
        ]);

    }

    /**
     * @Route("/program/{programName}", name="program")
     */
    public function showByProgram(string $programName): Response
    {

        if (!$programName) {
            $message = "Impossible d'afficher le programme , demande de programme vide.";
            $function = __FUNCTION__;
            return $this->goTo404($message, $function, true);
        }
        $programName = preg_replace(
        '/-/',
        ' ', ucwords(trim(strip_tags($programName)), "-"));

        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy([
                'title' => mb_strtolower($programName)
            ]);

        if (!$program) {
            $message = "Impossible d'afficher le programme demandé ( $programName ) n'a pas été trouver dans la base.";
            $function = __FUNCTION__;
            return $this->goTo404($message, $function, false);
        }
        $seasons = $program->getSeasons();

        $complexSeasons = [];

        foreach ($seasons as $season) {
            $complexSeasons[] = [
            "season" =>$season,
            "stringNumber" =>ucfirst(SELF::NUMBERS[$season->getNumber()])
            ];
        }

        return $this->render('wild/program.html.twig', [
            'program' => $program,
            "complexSeasons" => $complexSeasons,
        ]);

    }


    /**
     * @Route("/season/{id<[0-9]{1,5}>}", name="season")
     */
    public function showBySeason(int $id = 0 ){

        if (!$id || $id === 0) {
            $message = "Impossible d'afficher la saison demandée , demande vide.";
            $function = __FUNCTION__;
            return $this->goTo404($message, $function, true);
        }

        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy([
                'id' => $id
            ]);

        if (!$season) {
            $message = "Impossible d'afficher la saison demandée. La référence [ $id ] n'a pas été trouver dans la base.";
            $function = __FUNCTION__;
            return $this->goTo404($message, $function, false);
        }
        $episodes = $season->getEpisodes();
        $program = $season->getProgram();

        $complexEpisodes = [];
        $programNameLink = $program->getTitleUrlLinkFormated() ; // get the program name formated for isered link twig

        foreach ($episodes as $episode) {
            $complexEpisodes[] = [
                "episode" => $episode,
                "stringNumber" => ucfirst(SELF::NUMBERS[$episode->getNumber()])
            ];
        }

        return $this->render('wild/season.html.twig', [
            'program' => $program,
            "complexEpisodes" => $complexEpisodes,
            "season" => $season,
            "programNameLink" => $programNameLink
        ]);

    }

    /**
     * default route if no match
     * @Route("/show/{page}", name="show_default")
     */
    public function showNoMatch(string $page = "empty"): Response
    {

        $message = "Demande intercepté par une route de recupération pour [show] , la demande ne respecte pas les critere de  filtres. ";
        $function = __FUNCTION__;
        return $this->goTo404($message, $function, false);

    }



    /**
     * @Route("/new", methods={"POST"}, name="new")
     */
    public function create()
    {

    }

    /*
     *
     * @Route("/wild/{id}", methods={"DELETE"}, name="wild_delete")
     *
    public function delete(int $id = -1)
    {

        return $this->redirectToRoute('wild_show', ['page' => 1]);
    }*/

    private function goTo404(string $message , string $funtion, bool $displayOnlyMessage=false){
        try {
            $msgBefore = "";
            $msgAfter = "";
            if(!$displayOnlyMessage){
                $msgBefore = " 404 - Bad URL: ";
                $msgAfter = " Origine du  message: [ " . $funtion . " ]";
            }
            throw $this->createNotFoundException($msgBefore . $message );
        } catch (\Exception $e) {
                return $this->render('_404.html.twig', ['msg' => $e->getMessage(),"msgAfter" => $msgAfter]);
        }
    }

}
