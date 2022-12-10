<?php

namespace App\Controller\Auth;

use App\Form\LoginFormType;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ["GET", "POST"])]
    public function index(AuthenticationUtils $authenticationUtils, LoggerInterface $logger): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $form = $this->createForm(LoginFormType::class, null, [
            'method' => 'POST',
            'action' => $this->generateUrl('login')
        ]);

        return $this->render('auth/login/index.html.twig', [
            'error' => $error,
            'loginForm' => $form->createView()
        ]);
    }

    #[Route(path: '/logout', name: 'logout', methods: "POST")]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
