<?php

namespace SoftUniBlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SoftUniBlogBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SoftUniBlogBundle\Form\ArticleType;

class ArticleController extends Controller
{

    /**
     *
     * @Route("/article/create", name="article_create")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     */


    public function create(Request $request){

        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $article->setAuthor($this->getUser());
            $article->setSummary();
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            var_dump($article);
            $em->flush();

            return $this->redirectToRoute('blog_index');

        }



            return $this->render('article/create.html.twig', array('form' => $form->createView()));


    }


}
