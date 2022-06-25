<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Messages;
use App\Form\MessagesType;
use Symfony\Component\Security\Core\Security;
use App\Repository\MessagesRepository;
use App\Repository\UsersRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MessagesController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

    /**
     * @Route("/messages", name="messages")
     */
    public function index(): Response
    //Si l'utilisateur n'est pas connecté => Retour à la page de login
    {if (!$this->getUser()){
        return $this->redirectToRoute('app_login');
    }
        //Sinon, affihcer le résumé de la messagerie
        return $this->render('messages/index.html.twig', [
            'controller_name' => 'MessagesController',
        ]);
    }

    /**
     * @Route("/send", name="send")
     */
    public function send(Request $request): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        
        //Création d'un objet Message en utilisant le formulaire préalablement créé
        $message = new Messages();
        $form = $this->createForm(MessagesType::class, $message);
        //Permet de traiter le formulaire
        $form->handleRequest($request);

        //Vérification de la soumission puis de la cohérence des données
        if ($form->isSubmitted() && $form->isValid()) {
            
            $message->setSender($this->security->getUser());
            $message->setCreatedAt(new \DateTimeImmutable());

            //Utilisation du Entity manager pour mettre le message en bdd
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
     
            //Retour de la vue envoyer avec le formulaire afficher dessus
            $this->addFlash("message", "Message envoyé avec succès.");
            return $this->redirectToRoute("messages");
        }

        return $this->render("messages/send.html.twig", [
            "form" => $form->createView()
        ]);
    }
      /**
     * @Route("/reply/{to}", name="reply")
     * @param Messages $to
     */
    public function reply(Request $request, Messages $to, MessagesRepository $messagesRepository, UsersRepository $usersRepository): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        //Création d'un objet Message en utilisant le formulaire préalablement créé
        $oldMessage = $messagesRepository->find($to);
        $message = new Messages();
        $message->setTitle("Re: " . $oldMessage->getTitle());
        // $message->setRecipient($oldMessage->getSender());
        $message->setSender($this->getUser());
        $form = $this->createForm(MessagesType::class, $message)
            ->add('recipient', TextType::class, [
                "data" => $oldMessage->getSender()->getEmail(),
                "label" => "email",
                "attr" => [
                    "class" => "form-control",
                    "disabled" => true
                ]
            ]);
        //Permet de traiter le formulaire
        $form->handleRequest($request);
        //Vérification de la soumission puis de la cohérence des données
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            // var_dump($message);
            $recipient = $usersRepository->findBy(['email' => $formData->getRecipient()]);
            $message->setRecipient($recipient);
            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            //Alerte d'envoie de Message puis retour à la page d'accueil de message
            $this->addFlash("message", "Message envoyé avec succès.");
            return $this->redirectToRoute("messages");
        }
        return $this->renderForm("messages/send.html.twig", [
            "form" => $form
        ]);
    }
    
    /**
     * @Route("/received", name="received")
     */
    public function received(): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        return $this->render('messages/received.html.twig');
    }


    /**
     * @Route("/sent", name="sent")
     */
    public function sent(): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        return $this->render('messages/sent.html.twig');
    }

    /**
     * @Route("/read/{id}", name="read")
     */
    public function read(Messages $message): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $message->setIsRead(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        return $this->render('messages/read.html.twig', compact("message"));
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Messages $message): Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute("received");
    }
}
