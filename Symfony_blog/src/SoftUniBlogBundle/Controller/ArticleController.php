<?php

namespace SoftUniBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SoftUniBlogBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{

    /**
     * @param Request $request
     * @Route("/article/request", name="article_create")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     */


    public function create(Request $request){

        $article = new Article();

        $form = $this->createForm(AticleType::class, $article);

            return $this->render('article/create.html.twig', array('form' => $form->createView()));


    }


}
