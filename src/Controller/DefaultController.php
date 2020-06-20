<?php


namespace App\Controller;

use App\Entity\Program;
use App\Form\ProgramSearchType;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Reference;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     *
     * @Route("/", name="app_index")
     */
    public function index(Request $request) : Response
    {
        $pageTitle = "Last 3 series added : ";
        $form = $this->createForm(ProgramSearchType::class);
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
            $programs = $repository->findBy([],["title" =>"DESC"],3);
        }



        return $this->render('index.html.twig',
            [
                'website' => 'Wild Séries',
                "programs" => $programs,
                'form' => $form->createView(),
                "pageTitle" => $pageTitle
        ]);


    }
}
