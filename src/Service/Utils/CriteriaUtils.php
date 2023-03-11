<?php

namespace App\Service\Utils;

use App\Entity\Recipe;
use Doctrine\Common\Collections\Criteria;

class CriteriaUtils
{
    public static function createFilterByRecetteName(string $name) : Criteria
    {
        return Criteria::create()
            ->where(Criteria::expr()->contains('recette.name', '%'.$name.'%'));
    }

    public static function createFilterLikeRecetteByLike(Recipe $recette, $alias) : Criteria
    {
        return Criteria::create()->andWhere(
            Criteria::expr()->eq($alias, $recette)
        );
    }
}