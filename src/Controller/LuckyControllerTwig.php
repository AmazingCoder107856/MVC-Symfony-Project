<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{
    #[Route("/lucky/twig", name: "lucky")]
    public function number(): Response
    {
        $number = random_int(0, 100);
        $images = array('1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg', '7.jpg', '8.jpg', '9.jpg', '10.jpg');
        $images[array_rand($images)];

        $data = [
            'number' => $number,
            'images' => $images
        ];

        return $this->render('lucky.html.twig', $data);
    }

    #[Route("/api/quote/twig", name: "api_quote")]
    public function quote(): Response
    {
        $quotes = array(
            "The only sin is ignorance.",
            "A man is his own easiest dupe, for what he wishes to be true he generally believes to be true.",
            "A lie can travel halfway around the world while the truth is putting on its shoes.");

        $quotes[array_rand($quotes)];

        $data = [
            'quotes' => $quotes[array_rand($quotes)]
        ];

        return $this->render('quote.html.twig', $data);
    }

    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route("/api/twig", name: "api_web")]
    public function api(): Response
    {
        return $this->render('api.html.twig');
    }
}
