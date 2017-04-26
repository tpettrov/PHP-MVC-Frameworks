<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\Product;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Cart controller.
 *
 * @Route("cart")
 */
class CartController extends Controller
{
    /**
     * Lists all cart entities.
     *
     * @Route("/", name="cart_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $carts = $em->getRepository('AppBundle:Cart')->findAll();

        return $this->render('cart/index.html.twig', array(
            'carts' => $carts,
        ));
    }

    /**
     * Finds and displays a cart entity.
     *
     * @Route("/{id}", name="cart_show")
     * @Method("GET")
     */
    public function showAction(Cart $cart)
    {

        return $this->render('cart/show.html.twig', array(
            'cart' => $cart,
            'products' => $cart->getProducts()
        ));
    }

    /**
     * @Route("/{id}/order", name="order_cart")
     * @param Cart $cart
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     */

    public function orderCartAction(Cart $cart)
    {
        
        $user = $this->getUser();
        /** @var User $user */
        $user->setCash($user->getCash() - $cart->getCost());

        $buyedProducts = $cart->getProducts();
        $em = $this->getDoctrine()->getManager();

        foreach($buyedProducts as $product) {

            $newProduct = clone $product;
            /** @var Product $newProduct */
            $newProduct->setOwner($user);
            $newProduct->setQuantity('1');

            $em->persist($newProduct);
            $em->flush();
        }

        $cart->Empty();

        $cart->setStatus(false);
        $em->persist($user);
        $em->persist($cart);
        $em->flush();

        $this->addFlash('success', 'Order placed successfully ! Thank you !');
        return $this->redirectToRoute('product_index');

    }

    /**
     *
     */


}
