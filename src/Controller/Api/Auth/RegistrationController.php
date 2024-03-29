<?php

namespace App\Controller\Api\Auth;

use App\Dto\Api\Auth\UserRegistrationDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api.')]
class RegistrationController extends AbstractController
{
    /**
     * @param UserRegistrationDto $dto
     * @var string $username
     * @var string $email
     * @var string $password
     *
     * @param UserPasswordHasherInterface $passwordHasher
     * @param UserRepository $userRepository
     * @param Request $request
     * @param JWTTokenManagerInterface $JWTManager
     *
     * @return Response
     */
    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(
        UserRegistrationDto $dto,
        UserPasswordHasherInterface $passwordHasher,
        UserRepository $userRepository,
        Request $request,
        JWTTokenManagerInterface $JWTManager
    ): Response {

        if ($dto->hasErrors()) {
            return $this->json([
                'success' => false,
                'errors' => $dto->getErrors()
            ]);
        }

        $user = new User();
        $user->setUsername($dto->username);
        $user->setEmail($dto->email);

        $hashedPassword = $passwordHasher->hashPassword($user, $dto->password);
        $user->setPassword($hashedPassword);

        $ip = $request->getClientIp();
        $userAgent = $request->headers->get('User-Agent');
        $time = new \DateTime('now');
        $user->fillDataAfterSuccessfulAuthentication($ip, $userAgent, $time);

        $userRepository->save($user, true);

        $token = $JWTManager->create($user);

        return $this->json([
            'success' => true,
            'token' => $token,
            'roles' => $user->getRoles()
        ]);
    }

    // private EmailVerifier $emailVerifier;

    // public function __construct(public EmailVerifier $emailVerifier) {}
    
    // #[Route('/verify/email', name: 'app_verify_email')]
    // public function verifyUserEmail(Request $request): Response
    // {
    //     $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    //     // validate email confirmation link, sets User::isVerified=true and persists
    //     try {
    //         $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
    //     } catch (VerifyEmailExceptionInterface $exception) {
    //         $this->addFlash('verify_email_error', $exception->getReason());

    //         return $this->redirectToRoute('register');
    //     }

    //     // @TODO Change the redirect on success and handle or remove the flash message in your templates
    //     $this->addFlash('success', 'Your email address has been verified.');

    //     return $this->redirectToRoute('register');
    // }

    // // generate a signed url and email it to the user
    // $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
    //     (new TemplatedEmail())
    //         ->from(new Address('noreply@demo-crypto-exchange.com', 'Mail Bot'))
    //         ->to($user->getEmail())
    //         ->subject('Please Confirm your Email')
    //         ->htmlTemplate('registration/confirmation_email.html.twig')
    // );
    // // do anything else you need here, like send an email
}