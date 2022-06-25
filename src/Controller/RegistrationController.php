<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\AppAuthenticator;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use SebastianBergmann\Environment\Console;
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use SendGrid;
use Symfony\Component\Validator\Constraints\Email;

//require 'C:\Users\bouch\Desktop\L3AI_PROJET\projet\Integration finale\vendor\autoload.php';
require '../vendor/autoload.php';

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    // Chemin permettant la redirection vers la page d'inscription.
    #[Route('/register', name: 'app_register')]
    /**
     * Fonction permettant à l'utilisateur de s'inscrire.
     */
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, AppAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        //Création d'un nouveau utilisateur.
        $user = new User() ;

        //Crée et renvoie une instance Form à partir du type du formulaire.
        $form = $this->createForm(RegistrationFormType::class, $user);

        //Inspecte la requête donnée et appelle submit() si le formulaire a été soumis.
        $form->handleRequest($request);

        //Vérification: Remplissage correct du formulaire + Soumission.
        if ($form->isSubmitted() && $form->isValid()) {

            // Mis à jour du mot de passe de l'utilisateur (encodage).
            $user->setPassword(  
                // Encodage du mot de passe en utilisant la fonction de hachage proposée par symfony: hashPassword.
                // Arguments: l'utilisateur et le mot de passe.  
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            // Insertion de l'objet dans la base de données:

            // 1. Enregistrer l'objet dans le contexte de persistance.
            $entityManager->persist($user);
            // 2. Mis à jour des informations dans la table user dans la base de données.
            $entityManager->flush();

            // Envoi du mail de confirmation à l'utilisateur.
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                     //Adresse mail de l'expéditeur (Une @ valide est requise pour l'expéditeur).
                    ->from(new Address('noreplay@entraide.com', 'entraide2.0'))

                     //Adresse mail du destinataire (l'utilisateur en question).
                    ->to($user->email)

                     //Message affiché à l'utilisateur (Mail reçu).
                    ->subject('Bienvenue sur Entraide 2.0')
                    ->htmlTemplate('registration/confirmation_email.html.twig')    
                    ->context([
                        'username' => 'apikey',
                        'verify_peer'=>0,
                        'allow_self_signed'=>1,
                        'verify_peer_name'=>0
                    ])
            );
            // Renvoyer une réponse en cas de succès.
            $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
            return $this->redirectToRoute('app_notification'); 

        }
        //Redirection vers la page d'inscription
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    // Chemin permettant la redirection vers la page de vérification.
    #[Route('/verify/email', name: 'app_verify_email')]
    /**
     * Fonction permettant la confirmation de l'inscription par un lien envoyé à l'@ mail de l'utilisateur.
     */
    public function verifyUserEmail(Request $request): Response
    {
        //Interdiction de la connexion si l'adresse email n'est pas validée
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Confirmation de l'adresse email =>  User.isVerified = 1 dans la table user
        try {
            //Appel à la fonction handleEmailConfirmation qui prend en entrée le lien de confirmation
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            // Redirection vers la page d'inscription
            return $this->redirectToRoute('app_register');
        }

        $this->addFlash('success', 'Your email address has been verified.');

        //Si la confirmation est bien passée => redirection vers la page de bienvenue
        return $this->redirectToRoute('app_welcome'); 
    }
    
}