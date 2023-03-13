<?php

namespace App\Controller\api;

use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\LikeRepository;
use App\Repository\LikeRepositoryInterface;
use App\Repository\RecipeRepository;
use App\Repository\RecipeRepositoryInterface;
use App\Service\LikeManagerInterface;
use App\Service\LikeManagerManager;
use App\Service\RecipeManagerInterface;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class  CategoryController extends AbstractController
{
    private CategoryRepository $categoryRepository;
    private SerializerInterface $serializer;
    private RecipeManagerInterface $recipeManager;

    public function __construct(
        CategoryRepository     $categoryRepository,
        SerializerInterface    $serializer,
        RecipeManagerInterface $recipeManager,
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->serializer = $serializer;
        $this->recipeManager = $recipeManager;
    }

    #[Route('/categories', name: 'all_categories', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize(
                $this->categoryRepository->findAll(),
                'json',
                ["groups" => "getRecette"]
            ), Response::HTTP_OK, [], true
        );
    }

    #[Route('/category/{id}', name: 'one_category', methods: ['GET'])]
    public function findOneCategory(int $id): JsonResponse
    {
        $category = $this->categoryRepository->find($id);

        if (null === $category) {
            return new JsonResponse(
                $this->serializer->serialize(
                    'category not found',
                    'json'
                ), Response::HTTP_NOT_FOUND, [], true);
        }

        return new JsonResponse(
            $this->serializer->serialize(
                $this->recipeManager->getRecipeByCategories($category),
                'json',
                ["groups" => "getRecette"]
            ), Response::HTTP_OK, [], true
        );
    }
}
