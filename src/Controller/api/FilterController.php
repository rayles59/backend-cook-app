<?php

namespace App\Controller\api;

use App\Service\LikeManagerInterface;
use App\Service\LikeManagerManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class  FilterController extends AbstractController
{
    public function __construct(

    )
    {

    }

    #[Route('/recipe/filter',name: 'filter',methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {

        return new JsonResponse();
    }
}
