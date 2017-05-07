<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\BlackIP;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Blackip controller.
 *
 * @Route("admin/blackip")
 */
class BlackIPController extends Controller
{
    /**
     * Lists all blackIP entities.
     *
     * @Route("/", name="blackip_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blackIPs = $em->getRepository('AppBundle:BlackIP')->findAll();

        return $this->render('blackip/index.html.twig', array(
            'blackIPs' => $blackIPs,
        ));
    }

    /**
     * Creates a new blackIP entity.
     *
     * @Route("/new", name="blackip_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $blackIP = new Blackip();
        $form = $this->createForm('AppBundle\Form\BlackIPType', $blackIP);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blackIP);
            $em->flush();

            return $this->redirectToRoute('blackip_show', array('id' => $blackIP->getId()));
        }

        return $this->render('blackip/new.html.twig', array(
            'blackIP' => $blackIP,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a blackIP entity.
     *
     * @Route("/{id}", name="blackip_show")
     * @Method("GET")
     */
    public function showAction(BlackIP $blackIP)
    {
        $deleteForm = $this->createDeleteForm($blackIP);

        return $this->render('blackip/show.html.twig', array(
            'blackIP' => $blackIP,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing blackIP entity.
     *
     * @Route("/{id}/edit", name="blackip_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BlackIP $blackIP)
    {
        $deleteForm = $this->createDeleteForm($blackIP);
        $editForm = $this->createForm('AppBundle\Form\BlackIPType', $blackIP);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('blackip_edit', array('id' => $blackIP->getId()));
        }

        return $this->render('blackip/edit.html.twig', array(
            'blackIP' => $blackIP,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a blackIP entity.
     *
     * @Route("/{id}", name="blackip_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BlackIP $blackIP)
    {
        $form = $this->createDeleteForm($blackIP);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($blackIP);
            $em->flush();
        }

        return $this->redirectToRoute('blackip_index');
    }

    /**
     * Creates a form to delete a blackIP entity.
     *
     * @param BlackIP $blackIP The blackIP entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BlackIP $blackIP)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('blackip_delete', array('id' => $blackIP->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
