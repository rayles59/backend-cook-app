<?php

namespace App\Service;

use App\Entity\Log;
use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class LogRecipeManager implements LogManagerInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function writeLog(LifecycleEventArgs $args, string $action): void
    {
        $object = $args->getObject();
        $log = new Log();
        $log->setUserId($object->getUsers()->getId());
        $log->setCreatedAt(new \DateTimeImmutable());
        $log->setAction($action);
        $log->setEntity(get_class($object));
        $log->setEntityId($object->getId());
        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }
}