<?php

namespace App\Service;

use App\Entity\Recipe;
use App\Repository\CategoryRepository;
use App\Repository\RecipeRepository;
use App\Service\Utils\ArrayUtils;
use Doctrine\ORM\Query\QueryException;

class FilterManager implements FilterManagerInterface
{

    private RecipeRepository $recipeRepository;

    public function __construct(
        RecipeRepository $recipeRepository
    )
    {
        $this->recipeRepository = $recipeRepository;
    }


    /**
     * @throws QueryException
     */
    public function filterOnRecipe(array $params): array
    {
        $recipes = $this->recipeRepository->findRecipeByFilters($params);
        return $recipes;
    }
}