<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user')]
    public function index(
        UserRepository $userRepo
    ): Response {
        $users = $userRepo->findAll();

        return $this->render('project/user/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/user/create', name: 'user_create', methods: ["GET", "POST"])]
    public function createUser(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        if ($request->isMethod("GET")) {
            return $this->render('project/user/create.html.twig');
        }

        $username = strval($request->request->get('username'));
        $firstname = strval($request->request->get('firstname'));
        $lastname = strval($request->request->get('lastname'));
        $password = strval($request->request->get('password'));
        $image = strval($request->request->get('image'));

        $user = new User();
        $user->setUsername($username);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setPassword($password);
        $user->setImage($image);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('notification:', "Another user is successfully added.");

        return $this->redirectToRoute('user');
    }

    #[Route('/user/delete', name: 'user_delete', methods: ["GET", "POST"])]
    public function userDelete(
        Request $request,
        UserRepository $userRepo,
        ManagerRegistry $doctrine
    ): Response {
        $userId = $request->request->get('userId');
        $user = $userRepo->find($userId);
        $flash = "User cannot be found in the database.";

        if ($user) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
            $flash = $user->getUsername() . "has been deleted.";
        }

        $this->addFlash('notification', $flash);

        return $this->redirectToRoute('user');
    }

    #[Route('/user/update/{id<\d+>}', name: 'user_update', methods: ["GET", "POST"])]
    public function updateUser(
        UserRepository $userRepo,
        Request $request,
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $user = $userRepo->find($id);

        if (!$user) {
            $this->addFlash('notification:', "The user is not available.");

            return $this->redirectToRoute('user_update');
        }

        if ($request->isMethod("GET")) {
            return $this->render('project/user/update.html.twig', [
                'user' => $user
            ]);
        }

        $username = strval($request->request->get('username'));
        $firstname = strval($request->request->get('firstname'));
        $lastname = strval($request->request->get('lastname'));
        $password = strval($request->request->get('password'));
        $image = strval($request->request->get('image'));

        $user->setUsername($username);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setPassword($password);
        $user->setImage($image);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('notification', "Changes has been saved.");

        return $this->redirectToRoute('user');
    }
}
