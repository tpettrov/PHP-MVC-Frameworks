<?php
namespace AppBundle\EventListener;

use AppBundle\Repository\blackIPRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;


/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 5/7/2017
 * Time: 11:12
 *
 */
class KernelListener
{
    private $blackIps;

    public function __construct(BlackIPRepository $repo)
    {
        $this->blackIps = $repo->fetchAllIps();

    }


    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($event->getRequestType() !== \Symfony\Component\HttpKernel\HttpKernel::MASTER_REQUEST) {
            return;
        }


        if (in_array($event->getRequest()->getClientIp(), $this->blackIps)) {
            $event->setResponse(new Response('Your IP is banned. Go play somewhere else!', 403));
        }

    }
}