<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 * @Route("bikes")
 */
class ProductController extends Controller
{


    /**
     * Lists all product entities.
     *
     * @Route("/", name="product_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Product')->findAvailableProducts();

        return $this->render('product/index.html.twig', array(
            'products' => $products,
        ));
    }


    /**
     * @Route("/user_products/{id}", name="switch_sale")
     *
     */

    public function changeForSale(int $id){

        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository(Product::class)->findOneBy(['id' => $id]);

        if ($product->getForsale()) {

            $product->setForsale(false);
            $em->persist($product);
            $em->flush();
            $this->addFlash('success', 'Item returned for hold.');

        } else {
            $product->setForsale(true);
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Item is now listed for sale!');

        }

        return $this->redirectToRoute('product_index');


    }


    /**
     * Finds and displays a product entity.
     *
     * @Route("/{id}", name="product_show")
     * @Method("GET")
     */
    public function showAction(Product $product)
    {

        $addToCartFrom = $this->createAddToCartForm($product);

        return $this->render('product/show.html.twig', array(
            'product' => $product,
            'addtocart_form' => $addToCartFrom->createView(),
        ));
    }



    /**
     * Lists all product entities by category.
     *
     * @Route("/{category_name}/{category_id}", name="product_by_category")
     * @Method("GET")
     *
     */

    public function  showByCategoryAction (int $category_id){


        $em = $this->getDoctrine()->getManager();


        $products = $em->getRepository('AppBundle:Product')
            ->findAvailableProducts($category_id);

        return $this->render('product/index.html.twig', array(
            'products' => $products,
        ));

    }

    /**
     * @Route("/{id}", name="add_to_cart")
     * @Method("PATCH")
     */

    public function addToCartAction(Request $request, Product $product){

        $this->denyAccessUnlessGranted('ROLE_USER');

        $form = $this->createAddToCartForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var User $user */
            $user = $this->getUser();

            if($product->getOwner() == $user) {

                $this->addFlash('warning', "You already own this product!");
                return $this->redirectToRoute('user_bought_products');
            }

            // warning message if User is poor :)

            if ($user->getCash() < $product->getPrice()) {

                $this->addFlash('warning', "Insufficient funds !");
                return $this->redirectToRoute('product_index');

            }

            /** @var Cart $userCart */
            $userCart = $user->getCart();

            // adding the product and increasing price of Cart, setting status to True
            $userCart->addProduct($product);
            $product->setQuantity($product->getQuantity() - 1);
            $userCart->setStatus(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->persist($userCart);
            $em->flush();



        }

        return $this->redirectToRoute('product_index');

    }

    /**
     * @param Product $product
     * @return \Symfony\Component\Form\Form|\Symfony\Component\Form\FormInterface
     */

    private function createAddToCartForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('add_to_cart', array('id' => $product->getId())))
            ->setMethod('PATCH')
            ->getForm()
            ;
    }






}
