<?php

namespace App\DataFixtures;

use App\Entity\Messages;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
// pour gerer les dépendance et que ça ne soit pas lancé dans l'ordre Alpha
class MessagerieFixtures extends Fixture implements DependentFixtureInterface{
    public function load(ObjectManager $manager):void{
        $faker = Faker\Factory::create('fr_FR');
       
        //Boucle qui permet de générer les fausses annonces
        for($nbAnnonces = 1; $nbAnnonces <=50; $nbAnnonces++){
             //Permet de créer un message en prenant un utilateur aléatoire 
            $sender = $this->getReference('user_'.$faker->numberBetween(1,29));
            $recipient = $this->getReference(('user_'.$faker->numberBetween(1,29)));
            $message=new Messages();
            $message->setSender($sender);
            //Faker permet de prendre du text aleatoire en selectionnant une taille 
            $message->setTitle($faker->realText(15));
            $message->setMessage($faker->realText(50));
            $message->setRecipient($recipient);
            $manager->persist($message);
            
        }
        
      
        $manager->flush();
    }
    //retourne la liste des dépendances de notre fixtures message
    public function getDependencies()
    {
        return[UsersFixtures::class];
    }
}
