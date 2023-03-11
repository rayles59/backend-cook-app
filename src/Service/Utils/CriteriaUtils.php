<?php

namespace App\Service\Utils;

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
}