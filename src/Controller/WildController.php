<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WildController
 *
 * @package App\Controller
 * @Route("/wild", name="wild_")
 */
class WildController extends AbstractController
{
    /**
     * @Route("/", name="wild_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(): Response
    {
        return $this->render('wild/index.html.twig', ['website' => 'Wild Séries',]);
        //return new Response('<html><body>Wild Series Index</body></html>');
    }


    /**
     * @Route("/show/{slug<^[a-z0-9.-]*$>}", name="show")
     */
    public function show(string $slug): Response
    {
        //$regmatchExemple = "^[a-zA-Z0-9_.-]*$";
        //$regNotWork = "(^[a - z0 - 9. -]{1,})$";
        // $matches=[];
        //$test = preg_match_all("#$regmatchExemple#","produit-52",$matches);
        // var_dump($test);
        // var_dump($matches);
        if (empty($slug)) {
            $slug = "Aucune série sélectionnée, veuillez choisir une série";
        } else {
            $slug = str_replace("-", " ", $slug);
            var_dump($slug);
            $slug = ucwords($slug, " ");
        }
        return $this->render('wild/show.html.twig', ['page' => $slug]);
    }


    /**
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
