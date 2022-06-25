<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Annonce;
use App\Entity\Competence;
use App\Form\EditProfileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class EditProfileController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
       $this->security = $security;
    }

 
    #[Route('/profileUser', name: 'profileUser', methods: ['GET', 'POST'])]
    public function showMyProfile(ManagerRegistry $doctrine){
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        
        //Récuperer toutes les annonces dans la BD
        $user=$this->getUser();
        $repo=$doctrine->getRepository(Competence::class);
        $competence=$repo->findByidOwner($this->getUser()->getIdUser());
        $repo1=$doctrine->getRepository(Annonce::class);
        $annonce=$repo1->findByidOwner($this->getUser()->getIdUser());
        //retourner la page html avec toutes les annonces
        return $this->render('registration/monProfil.html.twig' ,[
            
            'user' =>$user,
            'competences' => $competence,
            'annonces' =>$annonce

        ]
    );
    }
    #[Route('/userAnnonce/{id}', name: 'UserAnnonce', methods: ['GET', 'POST'])]
    public function profile(ManagerRegistry $doctrine ,$id){
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        
        //Récuperer toutes les annonces dans la BD
        
        $repo=$doctrine->getRepository(Competence::class);
        $competence=$repo->findByidOwner($this->getUser()->getIdUser());
        $repo1=$doctrine->getRepository(Annonce::class);
        $annonce=$repo1->find($id);
        $user=$annonce->getIdOwner();
        $repo1=$doctrine->getRepository(Annonce::class);
        $annonces=$repo1->findByidOwner($user);
        //retourner la page html avec toutes les annonces
        return $this->render('registration/userAnnonce.html.twig' ,[
            
            'user' =>$user,
            'competences' => $competence,
            'annonces' =>$annonces

        ]
    );
    }
    /**
     * This controller allow us to edit user's profile
     *
     * @param User $choosenUser
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
   
    #[Route('/user/edit', name: 'user.edit', methods: ['GET', 'POST'])]
    
    public function editProfile(Request $request,ManagerRegistry $doctrine,SluggerInterface $slugger, EntityManagerInterface $em):Response{
        //vérifier que si le bon utilisateur qui essaye de modifier
        //vérifier s'il est connecté
         if(!$this ->getUser()){
            return $this->redirectToRoute('app_login');
        }

        $user= $this->security->getUser();

        //creer le form
        $form =$this->createForm(EditProfileType ::class ,$user);
        $form ->handleRequest($request);
        if($form ->isSubmitted() && $form->isValid()){
            $user =$form->getData();
            $imageFile = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $user->setImage($newFilename);
                
            }  
             /*   $fileName=md5(uniqid()).'.'.$imageFile->guessExtension();
                $em = $doctrine->getManager() ; 
                $user->setImage($imageFile);*/
            //}
            //$em = $doctrine->getManager() ;
            
            $em->persist($user);//persister les données
            $em->flush();
           
            $this ->addFlash(
                'success',
                'Vos informations ont été bien modifiées!'
            );

            return $this-> redirectToRoute('app_welcome');

        }
        
        
        return $this->render('registration/edit.html.twig',
             ['form' => $form -> createView(),
        ]);
        

    }
    
}
