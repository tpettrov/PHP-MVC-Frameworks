<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Money;
use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


class UserController extends Controller
{

     const INITIAL_CASH = 50.00;

    /**
     * @Route("/register", name="register_user")
     */

    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // save encoded password
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getRawPassword());
            $user->setPassword($password);

            // set default USER_ROLE to any newly registered

            $roleRepository = $this->getDoctrine()->getRepository(Role::class);
            $userRole = $roleRepository->findOneBy(['name' => 'ROLE_USER']);
            $user->addRole($userRole);
            $user->setCash(self::INITIAL_CASH);


            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Registration successful! You are ready to log in...');

            return $this->redirectToRoute('login_user');
        }


        return $this->render(
            'user/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/login", name="login_user")
     */

    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();


        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route ("/logout", name="logout")
     */

    public function logoutAction()
    {

        return null;

    }
}
