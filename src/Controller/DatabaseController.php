<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('api/stock', name: 'api_stock', methods: ['POST'])]
    public function getStatus (EntityManagerInterface $entityManager): JsonResponse
    {
        $request = Request::createFromGlobals();
        $productId = $request->get('product_id');
        $quantity = (int)$request->get('quantity');

        $productRepository = $entityManager->getRepository(Product::class);

        /** @var Product $product */
        $product = $productRepository->findOneBy(['product_id' => $productId]);
        $message = 'Please provide necessary product data';

        if($product)
        {
            $amount = $product->getStockAvailable();
            $message = $amount !== 0 && $amount >= $quantity ? 'article can be fulfilled' : 'article can not be fulfilled';
        }
        return new JsonResponse($message);
    }
}