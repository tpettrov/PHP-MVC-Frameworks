<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("admin", name="admin")
 */

class AdminController extends Controller
{
    /**
     * @Route("/", name="admin")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function indexAction()
    {
        return $this->render('admin/admin_index.html.twig');
    }
}
