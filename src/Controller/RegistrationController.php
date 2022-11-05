<?php

namespace App\Controller;

use App\Entity\User;
use App\Config\BanStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'app_registration')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        dump($request->request->get('email'));

        return $this->render('registration/index.html.twig');
    }
}
