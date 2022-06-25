<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Annonce;
use App\Entity\User;
use App\Form\AnnonceType;
use App\Form\AnnonceEditType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Security;




class HomeController extends AbstractController{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }
    /**
     * @Route("/", name="home")
     */

    public function index() :Response
    {
        return $this->render('accueil/home.html.twig');
    }
    /**
     * @Route("/mesAnnonce", name="mesAnnonces")
     * Affiche les annonces de l'utilisateur connecté
     */
    public function redirection(ManagerRegistry $doctrine) :Response
    {
        //Vérifier si l'utilisateur est bien connecté 
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
       $user =$this->getUser();
        //Récuperer toutes les annonces de l'utilisateur dans la BD
        $repo = $doctrine->getRepository(Annonce::class);
        $criteria = array('idOwner' => $this->security->getUser()->getIdUser());

        $annonces=$repo->findBy($criteria);
        //retourner la page html avec toutes les annonces
        return $this->render('annonce/MyAnnonces.html.twig' ,[
            'Controller_name'=>'homeController',
            'annonces' =>$annonces,
            'user'=>$user
        ]
    );

    }
      /**
     * @Route("/annoncesActives", name="AnnoncesActives")
     * Affiche les annonces actives
     */
    public function annoncesStatus(ManagerRegistry $doctrine  ) :Response
    {
        //Vérifier si l'utilisateur est bien connecté 
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
       
        //Récuperer toutes les annonces de l'utilisateur dans la BD
        $repo = $doctrine->getRepository(Annonce::class);
        $criteria = array('id_domaine' => $this->security->getUser()->getIdUser());

        $annonces=$repo->findBy($criteria);
        //retourner la page html avec toutes les annonces
        return $this->render('annonce/mesAnnonces.html.twig' ,[
            'Controller_name'=>'homeController',
            'annonces' =>$annonces
        ]
    );

    }
    /**
     * @Route("/Annonce/{idAnnonce}", name="annonce_vue")
     * 
     */
    public function show($idAnnonce ,ManagerRegistry $doctrine){
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        
        //Récuperer toutes les annonces dans la BD
        $repo = $doctrine->getRepository(Annonce::class);
        $annonce=$repo->find($idAnnonce);
        //retourner la page html avec toutes les annonces
        return $this->render('annonce/show.html.twig' ,[
            
            'annonce' =>$annonce
        ]
    );
    }
    /**
     * @Route("/AnnonceSearch/{idAnnonce}", name="annonce_vue_search")
     * 
     */
    public function show_annonceRecherche($idAnnonce ,ManagerRegistry $doctrine){
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        
        //Récuperer toutes les annonces dans la BD
        $repo = $doctrine->getRepository(Annonce::class);
        $annonce=$repo->find($idAnnonce);
        //retourner la page html avec toutes les annonces
        return $this->render('search/annoncesVue.html.twig' ,[
            
            'annonce' =>$annonce
        ]
    );
    }
    /**
     * @Route("/annonce", name="annonce")
     */
    public function addAnnonce(Request $request ,ManagerRegistry $doctrine,EntityManagerInterface $em):Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
       // $criteria = array('idOwner' => $this->security->getUser()->getIdUser());

       
        $annonce = new Annonce();//instancier l'entité annonce
        $form = $this->createForm(AnnonceType::class, $annonce);//Demande de creation de formulaire
        $form->handleRequest($request);//récuperer le form rempli

        if ($form->isSubmitted() && $form->isValid()) {//Si le formulaire a été soumis et les données saisies sont correctes
            $em = $doctrine->getManager() ; //instancier le manager de doctrine 
            //Ajout de la date de publication
            $annonce-> setPublicationDate(new \DateTime()) ;
            $annonce-> setStatus(true);
            $annonce-> setIdOwner( $this->security->getUser());
            $em->persist($annonce);//persister les données
            $em->flush();//envoyer les données en bdd
            //si l'operation est réussie 
            $this->addFlash('success', 'Votre annonce a bien été apubliée !');
            return $this->redirectToRoute('mesAnnonces');
         }
     
        return $this->render('annonce/annonce.html.twig', [
            'form' => $form->createView()//On passe la variable $form à la vue 
        ]);
    }
    /**
     * @Route("/Annonce/{Idannonce}/delete", name="annonce_delete")
     */

    /*public function deleteAnnonce($Idannonce ,Annonce $annonce,ManagerRegistry $doctrine,EntityManagerInterface $em)
    {
       
        //Récuperer toutes les annonces dans la BD
        $em = $doctrine->getManager();
        $em->remove($annonce.getAnnonce($Idannonce));
         $em->flush();//envoyer les données en bdd
        //retourner la page html avec toutes les annonces
        return $this->redirectToRoute('home');
    }*/
    /**
     * @Route("/Annonce/{id_Annonce}/delete", name="annonce_delete")
     * 
     */
    public function delete($id_Annonce ,ManagerRegistry $doctrine,EntityManagerInterface $em){
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        //Récuperer toutes les annonces dans la BD
        $repo = $doctrine->getRepository(Annonce::class);
        $annonce=$repo->find($id_Annonce);
        $em = $doctrine->getManager();
        $em->remove($annonce);
        $em->flush();
        //retourner la page html avec toutes les annonces
        return $this->redirectToRoute('mesAnnonces');
    }

    /**
     * @Route("/annonce/{id_Annonce}/edit", name="annonce_edit")
     */
    public function edditAnnonce($id_Annonce,Request $request ,ManagerRegistry $doctrine,EntityManagerInterface $em):Response
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $repo = $doctrine->getRepository(Annonce::class);
        $annonce=$repo->find($id_Annonce);
        $form = $this->createForm(AnnonceEditType::class, $annonce);//Demande de creation de formulaire
        $form->handleRequest($request);//récuperer le form rempli

        if ($form->isSubmitted() && $form->isValid()) {//Si le formulaire a été soumis et les données saisies sont correctes
            $em = $doctrine->getManager() ; //instancier le manager de doctrine 
            //Ajout de la date de publication
           
            $annonce-> setPublicationDate( $annonce-> getPublicationDate());
            $annonce-> setLastupdatetime(new \DateTime()) ;
            $em->persist($annonce);//persister les données
            $em->flush();//envoyer les données en bdd
            //si l'operation est réussie 
            $this->addFlash('success', 'Votre annonce a bien été apubliée !');
            return $this->redirectToRoute('mesAnnonces');
         }
         return $this->render('annonce/annonceEdit.html.twig', [
            'form' => $form->createView()//On passe la variable $form à la vue 
        ]);

    }
     /**
     * @Route("/userInfo", name="info")
     * 
     */
    public function info(ManagerRegistry $doctrine){
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        $id_user=$this->security->getUser()->getIdUser();
        //Récuperer toutes les annonces dans la BD
        $repo = $doctrine->getRepository(User::class);
        $user=$repo->find($id_user);
        //retourner la page html avec toutes les annonces
        return $this->render('registration/info.html.twig' ,[
            
            'user' =>$user
        ]
    );
    }


}

