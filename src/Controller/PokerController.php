<?php

namespace App\Controller;

use App\Project\Pokergame;
use App\Project\Pokerrules;
use App\Project\PokercompareHands;
use App\Project\PokerplayerBal;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PokerController extends AbstractController
{
    /**
    * @Route("/proj/poker/pokerstart", name="poker_process", methods={"POST"})
    */
    public function pokerProcess(
        Request $request,
        SessionInterface $session
    ) {
        $play = $request->request->get('playpoker');

        $playerMoney = new PokerplayerBal();
        $balance = $playerMoney->getBalance();

        $poker = $session->get("poker") ?? new Pokergame();
        $playerBal = $session->get("balance") ?? $balance;

        if ($play) {
            $poker->firstPlay();
            $session->set("poker", $poker);
            $session->set("balance", $playerBal);
        }
        return $this->redirectToRoute('poker-start');
    }

    /**
     * @Route("/proj/poker/pokerstart", name="poker-start", methods={"GET", "HEAD"})
     */
    public function pokerStart(
        SessionInterface $session
    ): Response {

        $poker = $session->get('poker');

        $playerBal = $session->get('balance');

        $data = [
            'player' => $poker ->getPlayerCard(),
            'dealer' => $poker ->getDealerCard(),
            'pot' => $poker->getPot(),
            'playerbal' => $playerBal
        ];

        return $this->render('project/pokerstart.html.twig', $data);
    }

    /**
     * @Route("/proj/poker/turnflop", name="poker-go", methods={"POST"})
     */
    public function pokerGo(Request $request, SessionInterface $session)
    {
        $fold = $request->request->get('fold');
        $raise = $request->request->get('raise');
        $amount = $request->request->get('amount');

        $poker = $session->get('poker');

        $playerBal = $session->get('balance');

        if ($fold) {
            return $this->redirectToRoute('poker');
        }
        if ($raise) {
            $playerBal = $playerBal - $amount;
            $poker->setPot($amount * 2);
            $poker->theFlop();
            $session->set("balance", $playerBal);
            $session->set("poker", $poker);
        }

        return $this->redirectToRoute('poker-flop');
    }

    /**
     * @Route("/proj/poker/turnflop", name="poker-flop", methods={"GET", "HEAD"})
     */
    public function turnFlop(SessionInterface $session): Response
    {
        $poker = $session->get('poker');

        $playerBal = $session->get('balance');

        $data = [
           'player' => $poker ->getPlayerCard(),
           'dealer' => $poker ->getDealerCard(),
           'pot' => $poker->getPot(),
           'playerbal' => $playerBal,
           'community' => $poker->getCommunityCards()
        ];

        return $this->render('project/turnflop.html.twig', $data);
    }

    /**
     * @Route("/proj/poker/turn", name="poker-turn-process", methods={"POST"})
     */
    public function turnProcess(Request $request, SessionInterface $session)
    {
        $fold = $request->request->get('fold');
        $raise = $request->request->get('raise');
        $amount = $request->request->get('amount');
        $check = $request->request->get('check');

        $poker = $session->get('poker');

        $playerBal = $session->get('balance');

        if ($fold) {
            return $this->redirectToRoute('poker');
        }

        if ($raise) {
            $playerBal = $playerBal - $amount;
            $poker->setPot($amount * 2);
            $poker->turn();
            $session->set("balance", $playerBal);
            $session->set("poker", $poker);
            return $this->redirectToRoute('poker-turn');
        }

        if ($check) {
            $poker->turn();
            $session->set("balance", $playerBal);
            $session->set("poker", $poker);
            return $this->redirectToRoute('poker-turn');
        }
    }

    /**
     * @Route("/proj/poker/turn", name="poker-turn", methods={"GET", "HEAD"})
     */
    public function turnGet(SessionInterface $session): Response
    {
        $poker = $session->get('poker');

        $playerBal = $session->get('balance');

        $data = [
            'player' => $poker ->getPlayerCard(),
            'dealer' => $poker ->getDealerCard(),
            'pot' => $poker->getPot(),
            'playerbal' => $playerBal,
            'community' => $poker->getCommunityCards()
        ];

        return $this->render('project/turn.html.twig', $data);
    }

    /**
     * @Route("/proj/poker/turnriver", name="poker-river-process", methods={"POST"})
     */
    public function riverProcess(Request $request, SessionInterface $session)
    {
        $fold = $request->request->get('fold');
        $raise = $request->request->get('raise');
        $amount = $request->request->get('amount');
        $check = $request->request->get('check');

        $poker = $session->get('poker');

        $playerBal = $session->get('balance');

        if ($fold) {
            return $this->redirectToRoute('poker');
        }
        if ($raise) {
            $playerBal = $playerBal - $amount;
            $poker->setPot($amount * 2);
            $poker->river();
            $session->set("balance", $playerBal);
            $session->set("poker", $poker);

            return $this->redirectToRoute('poker-river');
        }
        if ($check) {
            $poker->river();
            $session->set("balance", $playerBal);
            $session->set("poker", $poker);

            return $this->redirectToRoute('poker-river');
        }
    }

    /**
     * @Route("/proj/poker/turnriver", name="poker-river", methods={"GET", "HEAD"})
     */
    public function riverGet(SessionInterface $session): Response
    {
        $poker = $session->get('poker');

        $playerBal = $session->get('balance');

        $data = [
            'player' => $poker ->getPlayerCard(),
            'dealer' => $poker ->getDealerCard(),
            'pot' => $poker->getPot(),
            'playerbal' => $playerBal,
            'community' => $poker->getCommunityCards()
        ];

        return $this->render('project/turnriver.html.twig', $data);
    }

    /**
     * @Route("/proj/poker/gameover", name="poker-gameover-process", methods={"POST"})
     */
    public function gameEndProcess(Request $request, SessionInterface $session)
    {
        $fold = $request->request->get('fold');
        $raise = $request->request->get('raise');
        $amount = $request->request->get('amount');
        $check = $request->request->get('check');

        $poker = $session->get('poker');

        $playerBal = $session->get('balance');

        if ($fold) {
            return $this->redirectToRoute('poker');
        }
        if ($raise) {
            $playerBal = $playerBal - $amount;
            $poker->setPot($amount * 2);
            $session->set("balance", $playerBal);
            $session->set("poker", $poker);
            return $this->redirectToRoute('poker-bet');
        }
        if ($check) {
            $session->set("balance", $playerBal);
            $session->set("poker", $poker);
            return $this->redirectToRoute('poker-bet');
        }
        return $this->redirectToRoute('poker-end');
    }

    /**
     * @Route("/proj/poker/gameover", name="poker-bet", methods={"POST"})
     */
    public function gameOverProcess(
        SessionInterface $session,
        ManagerRegistry $doctrine,
    ): Response {

        $entityManager = $doctrine->getManager();

        $poker = $session->get('poker');

        $totalPot = $poker->getPot();
        $playerBal = $session->get('balance');

        $playerRule = new Pokerrules($poker->playerFullHand());
        $dealerRule = new Pokerrules($poker->dealerFullHand());

        $compare = new PokercompareHands();

        $playerH = $compare->checkPlayer($playerRule);
        $dealerH = $compare->checkDealer($dealerRule);

        $winner = $session->get('winner') ?? $compare->compareHand($playerH, $dealerH);

        if (str_contains($winner, "You won")) {
            $playerBal->setPositiveRes($playerBal + $totalPot);
            $session->set("balance", $playerBal);
            $session->set('winner', $winner);
        }

        if (str_contains($winner, "Draw")) {
            $newPot = $totalPot / 2;
            $playerBal->setPositiveRes($playerBal + $newPot);
            $session->set("balance", $playerBal);
            $session->set('winner', $winner);
        }

        if (str_contains($winner, "You lost")) {
            $playerBal->setNegativeRes($playerBal - $totalPot);
            $session->set('winner', $winner);
        }


        // $entityManager->persist($user);
        $entityManager->flush();

        $poker->resetPot();

        return $this->redirectToRoute('poker-end');
    }

     /**
     * @Route("/proj/poker/gameover", name="poker-end", methods={"GET"})
     */
    public function pokerEndGame(SessionInterface $session): Response
    {
        $poker = $session->get('poker');
        $playerBal = $session->get('balance');
        $compare = new PokercompareHands();
        $playerRule = new Pokerrules($poker->playerFullHand());
        $dealerRule = new Pokerrules($poker->dealerFullHand());
        $playerH = $compare->checkPlayer($playerRule);
        $dealerH = $compare->checkDealer($dealerRule);

        $winner = $session->get('winner') ?? $compare->compareHand($playerH, $dealerH);

        $data = [
            'player' => $poker ->getPlayerCard(),
            'dealer' => $poker ->getDealerCard(),
            'pot' => $poker->getPot(),
            'playerbal' => $playerBal,
            'community' => $poker->getCommunityCards(),
            'winner' => $winner
        ];

        return $this->render('project/gameover.html.twig', $data);
    }
}
