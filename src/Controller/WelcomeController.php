<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WelcomeController extends AbstractController
{
   
    #[Route('/notification', name: "app_notification")]
    public function welcome(): Response
    {
        return $this->render('registration/notification.html.twig', [
            'controller_name' => 'WelcomeController',
        ]);
    }
    
}