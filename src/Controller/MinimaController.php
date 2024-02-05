<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MinimaController extends AbstractController
{
    public function __construct(
        private readonly HttpClientInterface $client,
    )
    {}

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('api/minima', name: 'api_minima')]
    public function getMinima(): Response
    {
        $response = $this->client->request(
            'GET',
            'https://jsonplaceholder.typicode.com/posts'
        );

        $decodedContent = json_decode($response->getContent(), true);

        $minimas = [];
        foreach ($decodedContent as $contentUnit)
        {
            if(str_contains($contentUnit['body'], 'minima'))
            {
                $minimas[] = $contentUnit;
            }
        }

        return new JsonResponse($minimas);
    }
}