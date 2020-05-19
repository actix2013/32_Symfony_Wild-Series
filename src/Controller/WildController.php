<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;
use App\Entity\Category;

/**
 * Class WildController !
 *
 * @package App\Controller
 * @Route("/wild", name="wild_")
 */
class WildController extends AbstractController
{
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
     * @Route("/show/{slug<^[a-zA-Z0-9.-]*$>}", name="show")
     */
    public function show(string $slug): Response
    {
        //$regmatchExemple = "^[a-zA-Z0-9_.-]*$";
        //$regNotWork = "(^[a - z0 - 9. -]{1,})$";
        // $matches=[];
        //$test = preg_match_all("#$regmatchExemple#","produit-52",$matches);
        // var_dump($test);
        // var_dump($matches);

        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find a program in program\'s table.');
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with ' . $slug . ' title, found in program\'s table.'
            );
        }

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

        $programsRepository = null;
        //<editor-fold desc="Methode  pour lire les objets , pas la bonne methode">
        $programsRepository = $this->getDoctrine()
            ->getRepository(Program::class);
        $query = $programsRepository->createQueryBuilder('p')
            ->where('p.category = :cat')
            ->setParameter('cat', $category)
            ->orderBy('p.title', 'ASC')
            ->getQuery();
        $programs = $query->setMaxResults(3)->getResult();
        //</editor-fold>


        if (!$programs) {
            throw $this->createNotFoundException(
                "No program find for category $category->getName()"
            );
        }

        return $this->render('wild/category.html.twig', [
            'categoryName' => $category->getName(),
            "programs" => $programs,
        ]);

    }

    /**
     * default route if no match
     * @Route("/show/{page}", name="show_default")
     */
    public function showNoMatch(string $page = "empty"): Response
    {

        try {
            throw $this->createNotFoundException('404 - Bad URL : ' . $page . "in [Function : ".  __FUNCTION__ ."]");
        } catch (\Exception $e) {
            return $this->render('_404.html.twig', ['msg' => $e->getMessage()]);
        }

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

}
