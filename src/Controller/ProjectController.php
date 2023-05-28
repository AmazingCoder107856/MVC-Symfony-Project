<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * @Route("/proj", name="project_page")
     */
    public function projectPage(): Response
    {
        return $this->render('project/index.html.twig', ['user' => $this->getUser()]);
    }

    /**
     * @Route("/proj/thanks", name="thanks")
     */
    public function thanksPage(): Response
    {
        return $this->render('project/thanks.html.twig');
    }

    /**
     * @Route("/proj/metrics", name="project_metrics")
     */
    public function pokerMetrics(): Response
    {
        return $this->render('project/metrics.html.twig');
    }

    /**
     * @Route("/proj/doc", name="project_doc")
     */
    public function pokerDocumentation(): Response
    {
        return $this->render('project/doc.html.twig');
    }

    /**
     * @Route("/proj/about", name="project_about")
     */
    public function projectAbout(): Response
    {
        return $this->render('project/about.html.twig');
    }

    /**
     * @Route("/proj/poker", name="poker", methods={"GET","HEAD"})
     */
    public function pokerStart(): Response
    {

        // $session->clear();
        return $this->render('project/poker.html.twig');
    }

    /**
     * @Route("/proj/poker/{username}", name="prepoker", methods={"GET","HEAD"})
     */
    public function prePokerStart(
        UserRepository $userRepo,
        string $username
    ): Response {

        $user = $userRepo->find($username);

        if (!$user) {
            $this->addFlash('notification:', "You are not logged in. Please sign in to start playing.");

            return $this->redirectToRoute('app_login');
        }

        return $this->render('project/poker.html.twig', ['user' => $user->getUsername()]);
    }

    /**
     * @Route("/proj/poker/newgame", name="poker-newgame-process", methods={"POST"})
     */
    public function newgameProcess(Request $request, SessionInterface $session)
    {

        $exit = $request->request->get('exit');
        $continue = $request->request->get('continue');


        $poker = $session->get('poker');

        $playerBal = $session->get('balance');

        if ($exit) {
            return $this->redirectToRoute('project_page');
        }
        if ($continue) {
            $session->clear();
            return $this->redirectToRoute('poker');
        }

        return $this->redirectToRoute('project_page');
    }
}
