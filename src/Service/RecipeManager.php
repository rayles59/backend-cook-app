<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Favoris;
use App\Entity\Like;
use App\Entity\Recipe;
use App\Entity\User;
use App\Repository\RecipeRepository;
use App\Repository\RepositoryInterface;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class RecipeManager implements RecipeManagerInterface
{
    private RecipeRepository $recipeRepository;
    private UserRepository $userRepository;
    private ImageManagerInterface $imageManager;
    private string $image_directory;
    private RepositoryInterface $repository;
    private EntityManagerInterface $entityManager;
    private IngredientManagerInterface $ingredientManager;
    private CategoryManagerInterface $categoryManager;
    private RecipeStepManagerInterface $recipeStepManager;

    public function __construct
    (
        RecipeRepository           $recipeRepository,
        ImageManagerInterface      $imageManager,
        RepositoryInterface        $repository,
        EntityManagerInterface     $entityManager,
        UserRepository             $userRepository,
        IngredientManagerInterface $ingredientManager,
        CategoryManagerInterface   $categoryManager,
        RecipeStepManagerInterface $recipeStepManager,
        string                     $image_directory,

    )
    {
        $this->recipeRepository = $recipeRepository;
        $this->imageManager = $imageManager;
        $this->image_directory = $image_directory;
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
        $this->ingredientManager = $ingredientManager;
        $this->categoryManager = $categoryManager;
        $this->recipeStepManager = $recipeStepManager;
    }

    public function createRecipeFromRequest(array $request): void
    {
        $recipe = new Recipe();
        $recipe->setName($request['name']);
        $recipe->setDescriptions($request['description']);
        //$recipe->setUsers($this->userRepository->findOneBy($this->>getUser())));
        $recipe->setUsers($this->userRepository->findOneBy(['email' => $request['email']]));
        $recipe->setNumberOfPersons($request['number_of_persons']);
        $recipe->setGlucide($request['glucide']);
        $recipe->setProteine($request['proteine']);
        $recipe->setLipide($request['lipide']);
        $this->ingredientManager->addIngredientsInRecipe($recipe, $request['ingredients']);
        $this->categoryManager->addCategoryInRecipe($recipe, $request['categories']);
        $this->recipeStepManager->addRecipeStepsInRecipe($recipe, $request['steps']);
        $recipe->setCreationTime($request['creationTime']);
        $recipe->setCreatedAt(new \DateTime());
        $recipe->setUpdatedAt(new \DateTime());
        $this->recipeRepository->save($recipe, true);
    }

    public function updateRecipe(array $recipes, int $id): Recipe
    {
        $recipe = $this->recipeRepository->findOneBy(['id' => $id]);

        (!empty($recipes['name'])) ? $recipe->setName($recipes['name']) : '';
        (!empty($recipes['description'])) ? $recipe->setDescriptions($recipes['description']) : '';
        (!empty($recipes['number_of_persons'])) ? $recipe->setNumberOfPersons($recipes['number_of_persons']) : '';
        (!empty($recipes['creationTime'])) ? $recipe->setCreationTime($recipes['creationTime']) : '';
        (!empty($recipes['createdAt'])) ? $recipe->setCreatedAt(new \DateTime()) : '';
        (!empty($recipes['updatedAt'])) ? $recipe->setUpdatedAt(new \DateTime()) : '';

        //TODO update ingredients and category and recipeStep

        return $recipe;
    }

}