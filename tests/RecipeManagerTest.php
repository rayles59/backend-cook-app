<?php

namespace App\Tests;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use App\Service\HttpClientManager;
use App\Service\MailerManager;
use App\Service\RecipeManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class RecipeManagerTest extends KernelTestCase
{
    /** @test */
    public function TestUpdateRecipe(): void
    {
//        $this->assertInstanceOf(Recipe::class, $recipe);
    }
}