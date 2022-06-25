<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use App\Form\AnnonceType;

use Symfony\Component\HttpFoundation\Request;


class SearchController extends AbstractController
{
    #[Route('/searchjjj', name: 'app_search')]
    public function index(): Response
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }
     /**
     * @Route("/welcome", name="app_welcome")
     * 
     */
    public function searchBar()
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleSearch'))
            
            ->add('query', ChoiceType::class, [
                'label' => "Quels types d'annonces vous intéresse?",
                'choices'  => [
                    'Proposer de l\'aide' => 'Proposer de l\'aide',
                    'Demander de l\'aide' => 'Demander de l\'aide',
                
                ],
            ])
            ->add('query2', TextType::class, [
                'label' => "Adresse",
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez une adresse'
                ],

            ])
            ->add('query1', ChoiceType::class, [
                'label' => "Quel domaine vous intéresse ? ",
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Entrez le domaine'
                ],
                'choices'  => [
                'Animaux' => 'Animaux',
                'Babysitting'=> 'Babysitting',
                'Bricolage à domicile'=> 'Bricolage à domicile',
                'Cours Particuliers'=> 'Cours Particuliers',
                'Cuisine'=> 'Cuisine',
                'Déménagement'=> 'Déménagement',
                'Informatique'=>'Informatique'
            ],    
            ])
            ->add('recherche', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();
        return $this->render('search/searchBar.html.twig', [
            'form' => $form->createView(),
            'user'=>$this->getUser()
        ]);
   
        
    }
        /**
     * @Route("/handleSearch", name="handleSearch")
     * @param Request $request
     */
    public function handleSearchByType(Request $request, AnnonceRepository $repo)
    {

        $query = $request->request->get('form')['query'];
        $query1 = $request->request->get('form')['query1'];
        $query2 = $request->request->get('form')['query2'];
        if($query and $query2 and $query1) {
            $Annonces = $repo->findAnnoncesBytype($query,$query1,$query2);

            return $this->render('search/index.html.twig', [
                'annonces' => $Annonces
            ]);
        }
        return $this->render('search/index.html.twig',[
            'annonces' =>null
        ]);
       
    }
       /**
     * @Route("/handleSearchAll", name="handleSearchAll")
     * @param Request $request
     */
    public function handleSearchByall(Request $request, AnnonceRepository $repo)
    {

        $query = $request->request->get('form')['query'];
       
            $Annonces = $repo->findAnnoncesByAll($query);
            return $this->render('search/index.html.twig', [
                'annonces' => $Annonces
            ]);
        
       /* return $this->render('search/index.html.twig',[
            'annonces' =>null
        ]);*/
       
    }
}
