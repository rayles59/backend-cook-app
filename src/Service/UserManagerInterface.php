<?php

namespace App\Service;

use App\Entity\User;

interface UserManagerInterface
{
    public function getBestChef(): User;
}