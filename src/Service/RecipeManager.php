<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Recipe;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use App\Repository\RepositoryInterface;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class RecipeManager implements RecipeManagerInterface
{
    private RecipeRepository $recipeRepository;
    private CategoryRepository $categoryRepository;
    private IngredientManagerInterface $ingredientManager;
    private CategoryManagerInterface $categoryManager;
    private RecipeStepManagerInterface $recipeStepManager;

    public function __construct
    (
        RecipeRepository           $recipeRepository,
        IngredientManagerInterface $ingredientManager,
        CategoryManagerInterface   $categoryManager,
        RecipeStepManagerInterface $recipeStepManager,
        CategoryRepository         $categoryRepository,

    )
    {
        $this->recipeRepository = $recipeRepository;
        $this->ingredientManager = $ingredientManager;
        $this->categoryManager = $categoryManager;
        $this->categoryRepository = $categoryRepository;
        $this->recipeStepManager = $recipeStepManager;
    }

    public function createRecipeFromRequest(array $request, User $user): void
    {
        $recipe = new Recipe();
        $recipe->setName($request['name']);
        $recipe->setDescriptions($request['description']);
        $recipe->setUsers($user);
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

    public function updateRecipe(array $recipes, int $id): ?Recipe
    {
        $recipe = $this->recipeRepository->findOneBy(['id' => $id]);
        if (null !== $recipe) {
            (!empty($recipes['name'])) ? $recipe->setName($recipes['name']) : '';
            (!empty($recipes['description'])) ? $recipe->setDescriptions($recipes['description']) : '';
            (!empty($recipes['number_of_persons'])) ? $recipe->setNumberOfPersons($recipes['number_of_persons']) : '';
            (!empty($recipes['creationTime'])) ? $recipe->setCreationTime($recipes['creationTime']) : '';
            (!empty($recipes['createdAt'])) ? $recipe->setCreatedAt(new \DateTime()) : '';
            (!empty($recipes['updatedAt'])) ? $recipe->setUpdatedAt(new \DateTime()) : '';

            //TODO update ingredients and category and recipeStep
            (!empty($recipes['categories'])) ? $this->categoryManager->updateCategories($recipe, $recipes['categories']) : '';
            (!empty($recipes['categories'])) ? $this->ingredientManager->updateIngredients($recipe, $recipes['ingredients']) : '';
            (!empty($recipes['categories'])) ? $this->recipeStepManager->updateRecipeSteps($recipe, $recipes['recipeSteps']) : '';
            return $recipe;
        }


        return null;
    }

    /**
     * @return Recipe[]
     */
    public function getRecipeByCategories(Category $category): array
    {
        return $this->recipeRepository->findRecipeByCategory($category);
    }
}