<?php

namespace SoftUniBlogApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use SoftUniBlogBundle\Entity\Article;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SingleArticleController extends Controller
{
    /**
     * @Route("/articles/{id}", name="rest_api_article")
     * @Method({"GET"})
     * @param $id article id
     * @return JsonResponse
     */
    public function articleAction($id)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($id);
        if (null === $article) {
            return new Response(json_encode(array('error' => 'resource not found')),
                Response::HTTP_NOT_FOUND,
                array('content-type' => 'application/json')
            );
        }
        $serializer = $this->container->get('jms_serializer');
        $articleJson = $serializer->serialize($article, 'json');
        return new Response($articleJson,
            Response::HTTP_OK, array('content-type' => 'application/json')
        );
    }

}
