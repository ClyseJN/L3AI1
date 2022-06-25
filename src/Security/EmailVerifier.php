<?php

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;

class EmailVerifier
{
    private $verifyEmailHelper;
    private $mailer;
    private $entityManager;

    public function __construct(VerifyEmailHelperInterface $helper, MailerInterface $mailer, EntityManagerInterface $manager)
    {
        $this->verifyEmailHelper = $helper;
        $this->mailer = $mailer;
        $this->entityManager = $manager;
    }

    /**
     * Fonction permettant l'envoi de mail de confirmation à l'utilisateur.
     */
    public function sendEmailConfirmation(string $verifyEmailRouteName, UserInterface $user, TemplatedEmail $email): void
    {
        // Génération d'un URL de confirmation qui sera envoyé à l'utilisateur.
        $signatureComponents = $this->verifyEmailHelper->generateSignature(
            $verifyEmailRouteName,
            $user->getUserIdentifier(),
            $user->getUserIdentifier()
        );

        $context = $email->getContext();
        // Renvoie l'URL généré 
        $context['signedUrl'] = $signatureComponents->getSignedUrl();

        // Renvoie la Date d'éxpiration de l'URL 
        $context['expiresAtMessageKey'] = $signatureComponents->getExpirationMessageKey();
        $context['expiresAtMessageData'] = $signatureComponents->getExpirationMessageData();
        $email->context($context);

        // Envoi du mail à l'utilisateur
        $this->mailer->send($email);
    }

    /**
     * Fonction permettant traiter la confirmation de l'utilisateur.
     * @throws VerifyEmailExceptionInterface
     */
    public function handleEmailConfirmation(Request $request, UserInterface $user): void
    {
        $this->verifyEmailHelper->validateEmailConfirmation($request->getUri(), $user->getUserIdentifier(), $user->getUserIdentifier());
        
        // Mise à jour de l'attribut is_verified dans la base de données.
        $user->setIsVerified(true);

        // Enregistrer l'objet dans le contexte de persistance.
        $this->entityManager->persist($user);

        // Mis à jour des informations dans la table User dans la base de données.
        $this->entityManager->flush();

    }
}