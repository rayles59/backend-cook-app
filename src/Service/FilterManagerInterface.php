<?php

namespace App\Service;

use App\Entity\Recipe;

interface FilterManagerInterface
{
    /**
     * @return Recipe[]
     */
    public function filterOnRecipe(array $params): array;
}