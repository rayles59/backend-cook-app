<?php

namespace App\Service;


use App\Entity\Category;
use App\Entity\Recipe;
use App\Entity\User;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface RecipeManagerInterface
{
    public function createRecipeFromRequest(array $request, User $user): void;
    public function updateRecipe(array $recipes, int $id): ?Recipe;
    public function getRecipeByCategories(Category $category): array;

}