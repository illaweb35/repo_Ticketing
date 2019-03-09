<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController
 *
 * @Route("/{_locale}",requirements={"_locale" ="|fr|en|de|es"})
 */
class HomeController extends AbstractController
{
    /**
     * Display Homepage
     *
     * @Route("/", name="home_page")
     * @return void
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * Display the information page
     *
     * @Route("/infos", name="home_infos")
     * @return Response
     */
    public function infos()
    {

        return $this->render('home/infos.html.twig');
    }

    /**
     * Display about page
     *
     * @Route("/about", name="home_about")
     *
     * @return void
     */
    public function about()
    {
        return $this->render('home/about.html.twig');
    }
}
