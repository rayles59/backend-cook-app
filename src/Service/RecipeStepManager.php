<?php

namespace App\Service;

use App\Entity\Recipe;
use App\Entity\RecipeStep;
use App\Repository\RecipeStepRepository;
use Doctrine\ORM\EntityManagerInterface;

class RecipeStepManager implements RecipeStepManagerInterface
{
    private RecipeStepRepository $recipeStepRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(RecipeStepRepository $recipeStepRepository, EntityManagerInterface $entityManager)
    {
        $this->recipeStepRepository = $recipeStepRepository;
        $this->entityManager = $entityManager;
    }

    public function addRecipeStepsInRecipe(Recipe $recipe, array $recipeSteps): void
    {
        foreach ($recipeSteps as $recipeStep) {
            $rs = new RecipeStep();
            $rs->setRecipe($recipe);
            $rs->setName($recipeStep['name']);
            $rs->setDescriptions($recipeStep['description']);
            $this->recipeStepRepository->save($rs);
            $recipe->addRecipeStep($rs);
        }
    }

    public function updateRecipeSteps(Recipe $recipe, array $recipeSteps): void
    {
        foreach ($recipe->getRecipeStep() as $recipeStep) {
            $recipe->removeRecipeStep($recipeStep);
        }

        foreach ($recipeSteps as $recipeStep) {
            $rs = new RecipeStep();
            $rs->setRecipe($recipe);
            $rs->setName($recipeStep['name']);
            $rs->setDescriptions($recipeStep['description']);
            $this->entityManager->persist($rs);
        }
    }

}