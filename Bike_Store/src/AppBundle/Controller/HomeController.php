<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\Product;
use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

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

    /**
     * @Route("/user_products", name="user_bought_products")
     *
     */

    public function showUserProducts()
    {

        $user = $this->getUser();
        $calc = $this->get('price_calculator');

        $products = $user->getOwnedProducts();

        return $this->render('product/show_in_myproducts.html.twig', array(
            'products' => $products,
            'calculator' => $calc
        ));


    }


    /**
     * @Route("/usercart", name="cart_show")
     *
     */
    public function showUsersCartAction()
    {
        $user = $this->getUser();
        /** @var User $user */
        $cart = $user->getCart();
        $calc = $this->get('price_calculator');
        return $this->render('cart/show.html.twig', array(
            'cart' => $cart,
            'products' => $cart->getProducts(),
            'calculator' => $calc
        ));
    }

    /**
     * @Route("/aaa", name="blabla")
     */

    public function examAction (){

        $em = $this->getDoctrine()->getManager();
        $role = new Role();
        $role->setName('Pesho');

        $em->persist($role);
        $em->flush();

        return $this->redirectToRoute('product_index');


    }

}
