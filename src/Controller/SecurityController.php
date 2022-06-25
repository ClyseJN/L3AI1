<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    // Chemin permettant la redirection vers la page de connexion.
    #[Route(path: '/login', name: 'app_login')]
    /**
     * Fonction permettant à l'utilisateur de se connecter.
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
 
        // Obtenir l'erreur de connexion s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();
        // Dernier nom d'utilisateur entré par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        // Redirection vers la page de connexion
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    // Chemin permettant la retour vers la page de connexion en cas de déconnexion.
    #[Route(path: '/logout', name: 'app_logout')]
    /**
     * Fonction permettant la déconnexion de l'utilisateur.
     */
    public function logout(): Response
    {
        return $this->redirectToRoute('app_login'); 
    }
}