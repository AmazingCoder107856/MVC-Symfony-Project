<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
    public function pokerStart(SessionInterface $session): Response
    {
        $session->clear();
        return $this->render('project/poker.html.twig');
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
