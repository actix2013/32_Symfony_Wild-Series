<?php


namespace App\Controller;

use phpDocumentor\Reflection\DocBlock\Tags\Reference\Reference;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="app_index")
     */
    public function index() : Response
    {
        return $this->render('/index.html.twig', ['website' => 'Home']);
        //return new Response('<html><body>Wild Series Index</body></html>');
    }
}
