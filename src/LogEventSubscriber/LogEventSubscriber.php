<?php

namespace App\LogEventSubscriber;

use Doctrine\ORM\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class LogEventSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            Events::postRemove
        ];
    }

    public function postRemove()
    {
        
    }
}