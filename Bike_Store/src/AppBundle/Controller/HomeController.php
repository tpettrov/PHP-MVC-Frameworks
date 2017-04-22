<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @var $categories []
     */

    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * extract categories from DB and display them on categoryBar view, to be loaded on BaseTemplate
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function renderCategoriesAction()
    {

        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Category')->findAll();


        return $this->render('default/categoryBar.html.twig', array(
           'categories' => $categories
        ));


    }
}
