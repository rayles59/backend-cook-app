<?php

namespace App\Service;

use App\Entity\Recipe;

interface CategoryManagerInterface
{
    public function addCategoryInRecipe(Recipe $recipe, array $categories): void;
    public function updateCategories(Recipe $recipe, array $categories): void;
}