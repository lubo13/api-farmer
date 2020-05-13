<?php
/**
 * @package App
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class RequestSubscriber
 * @package App\EventSubscriber
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */
class RequestSubscriber extends Container implements EventSubscriberInterface
{

    /**
     * @return array|\array[][]
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest']],
        ];
    }

    /**
     * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
     */
    public function onKernelRequest(RequestEvent $event)
    {
        if ($user = $this->getUser()) {
            $request = $event->getRequest();
            $path    = $request->getPathInfo();
            if (!preg_match('/^\/api/', $path)) {
                $em          = $this->locator->get('doctrine.orm.entity_manager');
                $filter      = $em->getFilters()->enable('user_filter');
                $filterParam = $user ? $user->getId() : null;

                $filter->setParameter('user_id', $filterParam);

            }
        }
    }
}
