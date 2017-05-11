<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 5/11/2017
 * Time: 11:15
 */

namespace AppBundle\Service;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        // ...

        return new Response('You are not Admin ! Bye.', 403);
    }
}