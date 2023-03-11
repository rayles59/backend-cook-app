<?php

namespace App\Controller\api;

use App\Service\FilterManagerInterface;
use App\Service\LikeManagerInterface;
use App\Service\LikeManagerManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api')]
class  FilterController extends AbstractController
{
    private FilterManagerInterface $filterManager;
    private SerializerInterface $serializer;

    public function __construct(
        FilterManagerInterface $filterManager,
        SerializerInterface    $serializer
    )
    {
        $this->filterManager = $filterManager;
        $this->serializer = $serializer;
    }

    #[Route('/recipe/filter', name: 'filter', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $recipes = $this->filterManager->filterOnRecipe($request->toArray());

            return new JsonResponse(
                $this->serializer->serialize(
                    $recipes,
                    'json',
                    ['groups' => 'getRecette']
                ),
                Response::HTTP_OK, [], true
            );
        } catch (\Exception $exception) {
            return new JsonResponse(
                $this->serializer->serialize(
                    $exception->getMessage(),
                    'json'
                ),Response::HTTP_INTERNAL_SERVER_ERROR, [], true
            );
        }
    }
}
