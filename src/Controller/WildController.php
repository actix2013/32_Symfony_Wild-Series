<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WildController extends AbstractController
{
    /**
     * @Route("/wild", name="wild_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(): Response
    {
        return $this->render('wild/index.html.twig', ['website' => 'Wild Séries',]);
        //return new Response('<html><body>Wild Series Index</body></html>');
    }


    /**
     * test de creation de route pour deuxieme fonction
     * @Route("/bad", name="wild_bad")
     */
    public function bad(): Response
    {
        return new Response('<html><body>MyBad Function</body></html>');

    }


    /**
     * requirement reconnait un decimal
     * @Route("/wild/show/{page<\d+>}", name="wild_show",methods={"GET", "POST"})
     */
    public function show(int $page = 1): Response
    {
        $page = "[Methode GET and Number] " . $page;
        return $this->render('wild/show.html.twig', ['page' => $page]);
    }


    /**
     * le requirement peut etre ecrit directement a la suite de la variable encadrer de chevrons
     * @Route("/wild/show/{page<movies>}", name="wild_show_movies")
     */
    public function showMovies(string $page): Response
    {
        //$page = "La valeur parametre page a été intercepté par un requirement de route. <br> Valeur interceptée :
        // $movies";

        // affichage de la page
        return $this->render('wild/show.html.twig', ['page' => $page . " [REquirement by spécific Word] "]);
    }

    /**
     * @Route("/wild/show/{page2}", name="wild_empty")
     */
    public function showempty(string $page2): Response
    {
        return $this->render('wild/show.html.twig', ['page' => $page2]);
    }

    /**
     * @Route("/wild/new", methods={"POST"}, name="wild_new")
     */
    public function create()
    {

    }

    /**
     *
     * @Route("/wild/{id}", methods={"DELETE"}, name="wild_delete")
     */
    public function delete(int $id = -1)
    {

        return $this->redirectToRoute('wild_show', ['page' => 1]);
    }

}
