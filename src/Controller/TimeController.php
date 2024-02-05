<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;


class TimeController extends AbstractController
{
    #[Route('api/time', name: 'api_time')]
    public function getTime(): JsonResponse
    {
        $time = (new \DateTime())->format("Y-m-d H:i:s");
        return new JsonResponse($time);
    }
}