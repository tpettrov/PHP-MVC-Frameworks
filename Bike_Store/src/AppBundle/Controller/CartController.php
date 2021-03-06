<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\Product;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
            'products' => $cart->getProducts(),
            'calculator' => $calc
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
        $this->denyAccessUnlessGranted('ROLE_USER');
        $user = $this->getUser();
        /** @var User $user */

        $user->setCash($user->getCash() - $cart->getCost());

        $buyedProducts = $cart->getProducts();
        $em = $this->getDoctrine()->getManager();

        foreach ($buyedProducts as $product) {

            $newProduct = clone $product;
            /** @var Product $newProduct */
            $newProduct->setOwner($user);
            $newProduct->setQuantity('1');
            $newProduct->setForsale('false');

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
     * @Route("/{id}", name="remove_product_from_cart")
     * @param Product $product
     */

    public function removeProductFromCartAction(Product $product){
        //dump($product);exit;
        /** @var User $user */
        $user = $this->getUser();
        /** @var Cart $cart */
        $cart = $user->getCart();
        $cart->removeProduct($product);
        $cart->setCost($cart->getCost() - $product->getPrice());

        if ($cart->getProductCount() == 0) {

            $cart->setStatus(false);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($cart);
        $em->flush();



        $this->addFlash('success', 'Item Removed from Cart !');
        return $this->redirectToRoute('cart_show');
    }


}
