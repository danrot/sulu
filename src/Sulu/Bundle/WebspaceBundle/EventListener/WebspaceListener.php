<?php

namespace Sulu\Bundle\WebspaceBundle\EventListener;

use Sulu\Bundle\WebspaceBundle\Model\WebspaceCollection;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class WebspaceListener implements EventSubscriberInterface
{
    /**
     * @var WebspaceCollection
     */
    private $webspaceCollection;

    public function __construct(WebspaceCollection $webspaceCollection)
    {
        $this->webspaceCollection = $webspaceCollection;
    }

    public function setWebspaceAsRequestAttribute(GetResponseEvent $event)
    {
        //TODO implement correctly
        $event->getRequest()->attributes->set('webspace', $this->webspaceCollection->get('sulu_io'));
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['setWebspaceAsRequestAttribute', 512],
        ];
    }
}
