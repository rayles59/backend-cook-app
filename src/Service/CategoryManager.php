<?php

namespace App\Service;

use App\Entity\Recipe;
use App\Repository\CategoryRepository;
use App\Service\Utils\ArrayUtils;

class CategoryManager implements CategoryManagerInterface
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function addCategoryInRecipe(Recipe $recipe, array $categories): void
    {
        foreach ($categories as $category) {
            if (null !== $value = $this->categoryRepository->findOneBy(['name' => $category])) {
                $recipe->addCategory($value);
            }
        }
    }

    public function updateCategories(Recipe $recipe, array $categories): void
    {
        foreach ($recipe->getCategory() as $category) {
            $recipe->removeCategory($category);
        }

        foreach ($categories as $category) {
            if(null !== $value = $this->categoryRepository->findOneBy(['name' => $category])) {
                $recipe->addCategory($value);
            }
        }
    }
}