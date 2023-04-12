<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerJson
{
    #[Route("/api")]
    public function jsonPage(): Response
    {
        $routes = array(
            "/api/quote -> It's a route that shows the 'qoutes of the day' in random.",
            "/lucky/twig -> It's a route that shows lucky number in random.",
            "/ -> A home route and I wrote about myself.",
            "/about -> It's a route where you can read about the MVC course.",
            "/report -> It's a route that you can read about my report per project.",
            "/card -> It's the landing page of my Card Game.",
            "/card/deck -> It's a route that shows the deck of cards sorted by their colors.",
            "/card/deck/shuffle -> It's a route that shows the shuffled cards.",
            "/card/deck/draw -> It's a route that shows one drawn card.",
            "/card/deck/draw/:number -> It's a route that draw more than one cards.",
            "/game/card/init -> It's a route to start the Game.",
            "/game/card/play -> It's a route to choose cards.",
            "/game/card/roll -> It's a route to draw cards.",
            "game/card/save -> It's a route that save the total points.");

        $routes[array_rand($routes)];

        $data = [
            'routes' => $routes
        ];

        // $response = new Response();
        // $response->setContent(json_encode($data));
        // $response->headers->set('Content-Type', 'application/json');

        // return $response;
        // return new JsonResponse($data);
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/quote")]
    public function jsonQuote(): Response
    {
        $quotes = array(
            "The only sin is ignorance.",
            "A man is his own easiest dupe, for what he wishes to be true he generally believes to be true.",
            "A lie can travel halfway around the world while the truth is putting on its shoes.");

        $quotes[array_rand($quotes)];

        $data = [
            'quotes' => $quotes[array_rand($quotes)]
        ];

        // $response = new Response();
        // $response->setContent(json_encode($data));
        // $response->headers->set('Content-Type', 'application/json');

        // return $response;
        // return new JsonResponse($data);
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
