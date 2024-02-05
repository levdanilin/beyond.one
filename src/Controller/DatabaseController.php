<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class DatabaseController extends AbstractController
{
    #[Route('api/products', name: 'api_products')]
    public function getProducts(EntityManagerInterface $entityManager): JsonResponse
    {
        $productRepository = $entityManager->getRepository(Product::class);
        $products = $productRepository->getGeneralData();
        return new JsonResponse($products);
    }
}