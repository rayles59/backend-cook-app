<?php

namespace App\Service;

use Doctrine\Persistence\Event\LifecycleEventArgs;

interface LogManagerInterface
{
    public function writeLog(LifecycleEventArgs $args, string $action): void;
}