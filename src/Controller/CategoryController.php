<?php


namespace App\Controller;


use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CategoryType;

/**
 * Class CategoryController !
 *
 * @package App\Controller
 * @Route("/category", name="category_")
 */
class CategoryController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{


    /**
     * @Route("/add", name="add")
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
public function add(Request $request): Response
    {

        $pageTitle = "Add a category";
        $form = $this->createForm(CategoryType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $form->getData(); // $data contains $_POST data
            if ($data["searchField"] === "*") $data["searchField"] = "";
            $doctrine = $this->getDoctrine();
            $programsRepository = $doctrine->getRepository(Program::class);
            $query = $programsRepository->createQueryBuilder('p')
                ->where("p.title LIKE :Robot") //
                ->setParameter(':Robot', "%" . $data["searchField"] . "%")
                ->orderBy('p.title', 'ASC')
                ->getQuery();
            $programs = $query->setMaxResults(10)->getResult();
            $pageTitle = "Resultat de la recherche :";
            // TODO : Faire une recherche dans la BDD avec les infos de $data…
        } else {

            $doctrine = $this->getDoctrine();
            $repository = $doctrine->getRepository(Program::class);
            $programs = $repository->findAll();


        }


        /*if (!$programs) {
           throw $this->createNotFoundException("No program found in program's table");
        }*/
        return $this->render('category/add.html.twig', ['website' => 'Wild Séries', "programs" => $programs,
            'form' => $form->createView(), "pageTitle" => $pageTitle
        ]);

    }


    /**
     * @Route("/", name="index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(): Response
    {

        $pageTitle = "List of category :";
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository(Category::class);
        $categorys = $repository->findAll();
        /*if (!$programs) {
           throw $this->createNotFoundException("No program found in program's table");
        }*/
        return $this->render('category/index.html.twig', ['website' => 'Wild Séries', "categorys" => $categorys,
            "pageTitle" => $pageTitle
        ]);
    }


}
