<?php

namespace App\Service;

use App\Entity\Recipe;

interface RecipeStepManagerInterface
{
    public function addRecipeStepsInRecipe(Recipe $recipe, array $recipeSteps): void;
}