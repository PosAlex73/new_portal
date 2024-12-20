<?php

namespace App\Controller;

use App\Entity\User;
use App\Enums\Flash\FlashTypes;
use App\Enums\Users\UserTypes;
use App\Form\RegistrationFormType;
use App\Form\ResetPasswordType;
use App\Security\AppCustomAuthenticator;
use App\Security\EmailVerifier;
use App\Services\User\PasswordRestoreService;
use App\Services\User\RolesGetter;
use App\Services\User\UserRegistrator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    public function __construct(
        protected EmailVerifier $emailVerifier,
        protected UserRegistrator $userRegistrator,
        protected RolesGetter $rolesGetter,
        protected EntityManagerInterface $entityManager,
        protected ParameterBagInterface $parameterBag,
        protected PasswordRestoreService $passwordRestoreService

    ){}

    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        AppCustomAuthenticator $authenticator,
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setFirstName($form->get('firstName')->getData());
            $user->setLastName($form->get('lastName')->getData());
            $this->userRegistrator->registerUser($request, $user);

            $this->addFlash(FlashTypes::NOTICE->value,'На вашу почту было отправлено письмо. Необходимо подтвертить подлинность почтового ящика');

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address($this->parameterBag->get('app.admin_email'), $this->parameterBag->get('app.admin_name')))
                    ->to($user->getEmail())
                    ->subject('Подтвердите вашу почту!')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());

            $user = $this->getUser();
            $user->setRoles($this->rolesGetter->getRolesForUser(UserTypes::SIMPLE));
            $this->entityManager->flush();

        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash(FlashTypes::ERROR->value, $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        $this->addFlash(FlashTypes::NOTICE->value, 'Ваша почта была потверждена!');

        return $this->redirectToRoute('front_index');
    }

    #[Route('/reset-password', name: 'reset_password', methods: ['GET', 'POST'])]
    public function resetPassword(Request $request): Response
    {
        $restorePasswordForm = $this->createForm(ResetPasswordType::class);
        $restorePasswordForm->handleRequest($request);

        if ($restorePasswordForm->isSubmitted() && $restorePasswordForm->isValid()) {

        }

        return $this->render('registration/restore_password.html.twig', [
            'form' => $restorePasswordForm
        ]);
    }
}
