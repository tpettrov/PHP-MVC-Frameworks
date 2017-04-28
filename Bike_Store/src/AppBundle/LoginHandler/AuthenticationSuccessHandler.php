<?php

namespace AppBundle\LoginHandler;

use AppBundle\Entity\Cart;
use AppBundle\Entity\User;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Http\HttpUtils;

class AuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler
{
    protected $container;

    public function __construct(HttpUtils $httpUtils, \Symfony\Component\DependencyInjection\ContainerInterface $cont, array $options)
    {
        parent::__construct($httpUtils, $options);
        $this->container = $cont;
    }

    public function onAuthenticationSuccess(\Symfony\Component\HttpFoundation\Request $request, \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token)
    {
        $user = $token->getUser();

        /** @var User $user */
        if ($user->getCart() == null) {

            $cart = new Cart();
            $cart->setStatus(false);
            $user->setCart($cart);

            $em = $this->container->get('doctrine.orm.entity_manager');

            $em->persist($cart);

            $em->persist($user);
            $em->flush();

        }


        return $this->httpUtils->createRedirectResponse($request, $this->determineTargetUrl($request));
    }
}
