<?php
   
    

namespace App\Tests\func;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DomCrawler\Crawler;
use App\Form\AnnonceType;


//Tests fonctionnel pour le controlleur homeControleur


class homeControllerTest extends WebTestCase
{

    //1er test qui vérifie que la page d'accueil renvoie une réponse HTTP 200
    public function testIndex()
    {
        $client = static::createClient();//simule un navigateur. Au lieu de faire des appels HTTP au serveur, il appelle directement l'application Symfony
        $client->request('GET', '/');
        //le test valide que la réponse HTTP a réussi 
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
       
        //le test valide que le corps de la requête contient une balise <h1> avec 'Bienvenue sur Entr'aide 2.0'.
        
        $this->assertSelectorTextContains('h1', 'Bienvenue sur Entr\'aide 2.0');
       
    }
   public function testAddAnnoncespage()
    {
        $client = static::createClient();//simule un navigateur. Au lieu de faire des appels HTTP au serveur, il appelle directement l'application Symfony
        $client->request('GET', '/annonce');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    public function testShowAnnoncesPage()
    {
        $client = static::createClient();//simule un navigateur. Au lieu de faire des appels HTTP au serveur, il appelle directement l'application Symfony
        $client->request('GET', '/mesAnnonce');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    public function testShowPage()
    {
        $client = static::createClient();//simule un navigateur. Au lieu de faire des appels HTTP au serveur, il appelle directement l'application Symfony
        $client->request('GET', '/Annonce/1');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    public function deletePage()
    {
        $client = static::createClient();//simule un navigateur. Au lieu de faire des appels HTTP au serveur, il appelle directement l'application Symfony
        $client->request('GET', '/Annonce/2/delete');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    public function testEditPage()
    {
        $client = static::createClient();//simule un navigateur. Au lieu de faire des appels HTTP au serveur, il appelle directement l'application Symfony
        $client->request('GET', '/annonce/1/edit');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    
  

}
