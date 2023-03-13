<?php

namespace App\Controller\api;

use App\Repository\RecipeRepository;
use App\Service\FilterManagerInterface;
use App\Service\LikeManagerInterface;
use App\Service\LikeManagerManager;
use App\Service\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class  UserController extends AbstractController
{
    private SerializerInterface $serializer;
    private RecipeRepository $recipeRepository;

    public function __construct(
        SerializerInterface $serializer,
        RecipeRepository $recipeRepository
    )
    {
        $this->serializer = $serializer;
        $this->recipeRepository = $recipeRepository;
    }

    //TODO Il faut que cette route soit accesible sans Token
    #[Route('/user/bestChef', name: 'app_api_recipe_getbestchef', methods: 'GET')]
    public function getBestChefFromHomePage() : JsonResponse
    {
        //pour demain, il faut changer le retour api afin de récupèrer la dernière recette poster.
        try{
            return new JsonResponse(
                $this->serializer->serialize(
                    $this->recipeRepository->findRecipeWithBetterScoreOfLike(),
                    'json',
                    ["groups" => 'user:chef']
                ), Response::HTTP_OK, [], true
            );
        }catch (\Exception $exception)
        {
            return new JsonResponse(
                $this->serializer->serialize(
                    $exception->getMessage(),
                    'json'),
                Response::HTTP_INTERNAL_SERVER_ERROR,
                [],
                true
            );
        }
    }
}
