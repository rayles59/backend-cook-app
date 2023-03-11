<?php

namespace App\Service;

use App\Entity\Recipe;
use App\Repository\CategoryRepository;
use App\Service\Utils\ArrayUtils;

class FilterManager implements FilterManagerInterface
{

    public function filterOnRecipe(array $params): array
    {
        return [];
    }
}