<?php

namespace App\Controller;

use App\Game21\Game21;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class Game21Controller extends AbstractController
{
    /**
     * @Route("/game", name="game21_page")
     */
    public function game21Page(): Response
    {
        return $this->render('game/page.html.twig');
    }

    /**
     * @Route("/game/doc", name="game21_documentation")
     */
    public function game21Documentation(): Response
    {
        return $this->render('game/doc.html.twig');
    }

    /**
     * @Route("/game/game21", name="game21", methods={"GET","HEAD"})
     */
    public function game21(SessionInterface $session): Response
    {
        $session->clear();

        return $this->render('game/game21.html.twig');
    }

    /**
    * @Route("/game/game21start", name="game21_process", methods={"POST"})
    */
    public function game21Process(Request $request, SessionInterface $session)
    {
        $play = $request->request->get('play');

        $game21 = $session->get("game21") ?? new Game21();

        if ($play) {
            $game21->firstPlay();
            $session->set('game21', $game21);
        }

        return $this->redirectToRoute('game21_start');
    }

    /**
     * @Route("/game/game21start", name="game21_start", methods={"GET", "HEAD"})
     */
    public function game21Start(SessionInterface $session): Response
    {
        $game21 = $session->get('game21');

        $data = [
            'dealer' => $game21 ->getDealerCards(),
            'player' => $game21 ->getPlayerCards(),
            'dealerscore' => $game21 ->getDealerScore(),
            'playerscore' => $game21->getPlayerScore(),
            'firstdraw' => $game21 ->checkFirstDraw()
        ];

        return $this->render('game/game21start.html.twig', $data);
    }

    /**
     * @Route("/game/game21go", name="game21_go", methods={"POST"})
     */
    public function game21GoProcess(Request $request, SessionInterface $session)
    {
        $stay  = $request->request->get('stay');
        $hit = $request->request->get("hit");
        $game21 = $session->get("game21") ?? new Game21();

        if ($hit) {
            $game21->playerHit();
            $session->set('game21', $game21);
            return $this->redirectToRoute('game21_start');
        }

        if ($stay) {
            return $this->redirectToRoute('game21_stop');
        }
    }

    /**
     * @Route("/game/game21stop", name="game21_stop", methods={"GET", "HEAD"})
     */
    public function game21Stop(SessionInterface $session): Response
    {
        $game21 = $session->get("game21") ?? new Game21();

        $data = [
        'gamestop' => $game21->gameStop(),
        'dealer' => $game21 ->getDealerCards(),
        'player' => $game21 ->getPlayerCards(),
        'dealerscore' => $game21 ->getDealerScore(),
        'playerscore' => $game21->getPlayerScore(),
        ];

        return $this->render('game/game21stop.html.twig', $data);
    }
}
