<?php

namespace App\Controller\Auth;

use App\Dto\UserLoginDto;
use App\Form\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ["GET", "POST"])]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $userLoginDto = new UserLoginDto();
        $form = $this->createForm(LoginFormType::class, $userLoginDto, [
            'method' => 'POST',
            'action' => $this->generateUrl('login')
        ]);

        return $this->render('auth/login/index.html.twig', [
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'loginForm' => $form->createView()
        ]);
    }

    #[Route(path: '/logout', name: 'logout', methods: "POST")]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
