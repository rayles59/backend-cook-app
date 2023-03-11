<?php

namespace App\Service;

use App\Entity\Ingredient;
use App\Entity\Recipe;

interface IngredientManagerInterface
{
    public function addIngredientsFromXlsx(array $data) : bool;
    public function addIngredientsInRecipe(Recipe $recipe, array $ingredients) : void;
    public function updateIngredients(Recipe $recipe, array $ingredients): void;

    /**
     * @param array $ingredients
     * @return Ingredient[]
     */
    public function getIngredientsInArray(array $ingredients): array;

}