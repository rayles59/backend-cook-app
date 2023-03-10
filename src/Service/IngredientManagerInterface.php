<?php

namespace App\Service;

use App\Entity\Recipe;

interface IngredientManagerInterface
{
    public function addIngredientsFromXlsx(array $data) : bool;
    public function addIngredientsInRecipe(Recipe $recipe, array $ingredients) : void;

}