<?php

namespace App\EventListener;

use App\Entity\Recipe;
use App\Service\LogManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class LogEventSubscriber implements EventSubscriberInterface
{
    private LogManagerInterface $logManager;

    public function __construct(LogManagerInterface $logManager)
    {
        $this->logManager = $logManager;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::preRemove,
            Events::postUpdate
        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        if($args->getObject() instanceof Recipe)
        {
            $this->logManager->writeLog($args, 'CREATE');
        }
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        if($args->getObject() instanceof Recipe)
        {
            $this->logManager->writeLog($args, 'REMOVE');
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        if($args->getObject() instanceof Recipe)
        {
            $this->logManager->writeLog($args, 'EDIT');
        }
    }
}