<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Product controller.
 *
 * @Route("admin/bikes")
 */
class ProductController extends Controller
{

    /**
     * Lists all product entities.
     *
     * @Route("/", name="product_index_admin")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Product')->findAll();

        return $this->render('admin/product/index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Creates a new product entity.
     *
     * @Route("/create", name="product_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('AppBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $file = $product->getImageForm();

            if (!$file) {
                //$form->get('image_form')->addError(new FormError('Image is required'));
            } else {
                $filename = md5($product->getModel() . '' . $product->getCategory());

                $file->move(
                    $this->get('kernel')->getRootDir() . '/../web/images/bike/',
                    $filename
                );

                $product->setImage($filename);


                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();

                return $this->redirectToRoute('product_show_admin', array('id' => $product->getId()));
            }
        }

            return $this->render('admin/product/new.html.twig', array(
                'product' => $product,
                'form' => $form->createView(),
            ));
        }


    /**
     * Finds and displays a product entity.
     *
     * @Route("/{id}", name="product_show_admin")
     * @Method("GET")
     */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render(':admin/product:show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Product $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/edit", name="product_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('AppBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {


            if ($product->getImageForm() instanceof UploadedFile) {
                /** @var UploadedFile $file */
                $file = $product->getImageForm();

                $filename = md5($product->getModel() . '' . $product->getDescription());

                $file->move(
                    $this->get('kernel')->getRootDir() . '/../web/images/bikes/',
                    $filename
                );

                $product->setImage($filename);
            }



            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Product edited successfully!');

            return $this->redirectToRoute('product_edit', array('id' => $product->getId()));
        }

        return $this->render(':admin/product:edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a product entity.
     *
     * @Route("/{id}", name="product_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $product->setForsale(false);
            $em->persist($product);
            $em->flush();
            $this->addFlash('success', 'Product deleted successfully!');
        }

        return $this->redirectToRoute('product_index');
    }

    /**
     * Lists all product entities by category.
     *
     * @Route("/{category_name}/{category_id}", name="product_by_category")
     * @Method("GET")
     *
     */

    public function showByCategoryAction(int $category_id)
    {


        $em = $this->getDoctrine()->getManager();


        $products = $em->getRepository('AppBundle:Product')
            ->findAvailableProducts($category_id);

        return $this->render('product/index.html.twig', array(
            'products' => $products,
        ));

    }


}
