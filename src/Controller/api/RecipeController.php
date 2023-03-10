<?php

namespace App\Controller\api;

use App\Entity\Category;
use App\Entity\Recipe;
use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use App\Repository\UserRepository;
use App\Service\RecipeManager;
use App\Service\RecipeManagerInterface;
use Doctrine\ORM\EntityManagerInterface;
use MongoDB\Driver\Exception\ExecutionTimeoutException;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api')]
class RecipeController extends AbstractController
{
    private RecipeRepository $recipeRepository;
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;
    private UserRepository $userRepository;
    private CategoryRepository $categoryRepository;
    private RecipeManagerInterface $recipeManager;

    public function __construct(
        CategoryRepository     $categoryRepository,
        UserRepository         $userRepository,
        RecipeRepository       $recipeRepository,
        SerializerInterface    $serializer,
        EntityManagerInterface $entityManager,
        RecipeManagerInterface $recipeManager
    )
    {
        $this->recipeRepository = $recipeRepository;
        $this->categoryRepository = $categoryRepository;
        $this->serializer = $serializer;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->recipeManager = $recipeManager;
    }

    #[Route('/recipe', name: 'app_recipe', methods: 'GET')]
    public function index(): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize($this->recipeRepository->findAll(),
            'json', ["groups" => "getRecette"]),
            Response::HTTP_OK,
            [],
            true
        );
    }

    #[Route('/recipe/{id}', name: 'app_one_recipe', methods: 'GET')]
    public function findOneRecipe(int $id): JsonResponse
    {
        $recipe = $this->recipeRepository->findOneBy(['id' => $id]);

        if(null === $recipe)
            return new JsonResponse($this->serializer->serialize("Recipe not found",'json'),Response::HTTP_INTERNAL_SERVER_ERROR, [], true);

        return new JsonResponse(
            $this->serializer->serialize($recipe,
                'json', ["groups" => "getRecette"]),
            Response::HTTP_OK,
            [],
            true
        );
    }

    #[Route('/recipe/{id}', name: 'app_delete_recipe', methods: 'DELETE')]
    public function deleteRecipe(int $id): JsonResponse
    {
        $recipe = $this->recipeRepository->findOneBy(['id' => $id]);

        if(null === $recipe)
            return new JsonResponse($this->serializer->serialize("Recipe doesn't exist",'json'),Response::HTTP_BAD_REQUEST, [], true);

        $this->recipeRepository->remove($recipe);
        $this->entityManager->flush();
        return new JsonResponse(
            null,
            Response::HTTP_NO_CONTENT
        );

    }

    #[Route('/recipe', name: 'app_post_recipe', methods: 'POST')]
    public function postRecipe(Request $request): JsonResponse
    {
        try {
            $this->recipeManager->createRecipeFromRequest($request->toArray());
            return new JsonResponse($this->serializer->serialize(
                'You have add a new Recipe !'
                ,'json',[]),
                Response::HTTP_CREATED,
                [],
                true
            );
        }catch (\Exception $exception) {
            return new JsonResponse($this->serializer->serialize(
                $exception->getMessage()
                ,'json',[]),
                Response::HTTP_INTERNAL_SERVER_ERROR,
                [],
                true
            );
        }
    }

    #[Route('/recipe/{id}', name: 'app_update_recipe', methods: 'PUT')]
    public function putRecipe(int $id, Request $request) : JsonResponse
    {
        try{
            $recipe = $this->recipeManager->updateRecipe($request->toArray(), $id);
            $this->recipeRepository->save($recipe, true);
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
        return new JsonResponse();
    }

}
