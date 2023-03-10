<?php

namespace App\Service;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;

class IngredientManager implements IngredientManagerInterface
{
    private EntityManagerInterface $entityManager;
    private IngredientRepository $ingredientRepository;
    public function __construct(EntityManagerInterface $entityManager, IngredientRepository $ingredientRepository)
    {
        $this->entityManager = $entityManager;
        $this->ingredientRepository = $ingredientRepository;
    }

    public function addIngredientsFromXlsx(array $data) : bool
    {
        foreach ($data as $row){
            if(null !== $row[0])
            {
                try{
                    $ingredient = new Ingredient();
                    $ingredient->setName($row[0]);
                    (!is_string($row[1])) ? $ingredient->setProteines($row[1]) : $ingredient->setProteines(intval(($row[1])));
                    (!is_string($row[2])) ? $ingredient->setGlucides($row[2]) : $ingredient->setGlucides(intval($row[2]));
                    (!is_string($row[3])) ? $ingredient->setLipides($row[3]) : $ingredient->setLipides(intval($row[3]));
                    $this->entityManager->persist($ingredient);
                }catch (\Exception $e){
                    return false;
                }

            }
        }

        $this->entityManager->flush();

        return true;
    }

    public function addIngredientsInRecipe(Recipe $recipe, array $ingredients) : void
    {
        foreach ($ingredients as $ingredient)
        {
            if(null !== $value = $this->ingredientRepository->findOneBy(['name' => $ingredient]))
            {
                $recipe->addIngredient($value);
            }
        }
    }
}