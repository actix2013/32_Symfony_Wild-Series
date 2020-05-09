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
    public function index() :Response
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

}
