<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\ErrorHandler\Error\UndefinedFunctionError;

class UserManager implements UserManagerInterface
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function getBestChef(): User
    {

        return $this->userRepository->findBestChefByRecipePosted();
    }
}