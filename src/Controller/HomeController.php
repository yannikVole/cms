<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    /**
     * @Route("/",name="home_index")
     */
    public function index(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render("home/index.html.twig");
    }
}