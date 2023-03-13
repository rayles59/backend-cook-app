<?php

namespace App\Service\Utils;

use App\Entity\Category;
use App\Entity\Ingredient;
use App\Entity\Recipe;
use Doctrine\Common\Collections\Criteria;

class CriteriaUtils
{
    public static function createFilterByRecetteName(string $name): Criteria
    {
        return Criteria::create()
            ->where(Criteria::expr()->contains('recipe.name', '%' . $name . '%'));
    }
    public static function createFilterByUserName(string $name): Criteria
    {
        return Criteria::create()
            ->where(Criteria::expr()->contains('user.fullName', '%' . $name . '%'));
    }

    public static function createRecipeByCategory(Category $category): Criteria
    {
        return Criteria::create()->andWhere(
            Criteria::expr()->eq('category', $category)
        );
    }
}