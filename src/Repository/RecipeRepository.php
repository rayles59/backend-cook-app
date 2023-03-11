<?php

namespace App\Repository;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use App\Entity\User;
use App\Service\IngredientManagerInterface;
use App\Service\Utils\CriteriaUtils;
use App\Service\Utils\StringUtils;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 *
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository implements RepositoryInterface, RecipeRepositoryInterface
{
    private IngredientManagerInterface $ingredientManager;

    public function __construct(
        ManagerRegistry            $registry,
        IngredientManagerInterface $ingredientManager
    )
    {
        parent::__construct($registry, Recipe::class);
        $this->ingredientManager = $ingredientManager;
    }

    public function save(Recipe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Recipe $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findTenLastObject(int $recette = 10): ?array
    {
        return $this->createQueryBuilder('recette')
            ->setMaxResults($recette)
            ->orderBy('recette.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findTopThreeBestLikedRecipe(): ?array
    {
        return $this->createQueryBuilder('recette')
            ->select('recette, COUNT(l.isLike)')
            ->innerJoin('recette.likes', 'l')
            ->andWhere('l.isLike = true')
            ->groupBy('recette.id')
            ->orderBy('COUNT(l.isLike)', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function findRecipeByUser(User $user): ?array
    {
        return $this->createQueryBuilder('r')
            ->addCriteria(self::createRecipeByUser($user))
            ->orderBy('r.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public static function createRecipeByUser(User $user): Criteria
    {
        return Criteria::create()->andWhere(
            Criteria::expr()->eq('r.users', $user)
        );
    }

    public function findLikesByUser(User $user): ?array
    {
        return $this->createQueryBuilder('r')
            ->innerJoin('r.likes', 'l')
            ->addCriteria(self::createLikeByUser($user))
            ->orderBy('r.id', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public static function createLikeByUser(User $user): Criteria
    {
        return Criteria::create()->andWhere(
            Criteria::expr()->andX(
                Criteria::expr()->eq('l.user', $user->getId()),
                Criteria::expr()->eq('l.isLike', true)
            )
        );
    }

    /**
     * @throws QueryException
     */
    public function findRecipeByFilters(array $params): array
    {
        $qb = $this->createQueryBuilder('recipe')
            ->innerJoin('recipe.ingredients', 'ingredient');
        $qb = $this->filterByValue($qb, $params);

        return $qb->getQuery()->getResult();
    }

    /**
     * @throws QueryException
     */
    private function filterByValue(QueryBuilder $qb, array $params): QueryBuilder
    {
        if (StringUtils::isValueNotEmptyOrNull($params['recipe_name'])) {
            $qb->addCriteria(CriteriaUtils::createFilterByRecetteName($params['recipe_name']));
        }

        if (count($params['ingredients_contain'])) {
            $ingredients = $this->ingredientManager->getIngredientsInArray($params['ingredients_contain']);
            $qb = $this->findIngredientInListOfIngredients($qb, $ingredients);
        }

        return $qb;
    }

    /**
     * @param Ingredient[] $ingredients
     * @throws QueryException
     */
    private function findIngredientInListOfIngredients(QueryBuilder $qb, array $ingredients): QueryBuilder
    {

        $qb->andWhere($qb->expr()->in('ingredient', ':ingredients'))
            ->setParameter('ingredients', $ingredients);

        return $qb;
    }
}
