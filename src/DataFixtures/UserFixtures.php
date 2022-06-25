<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{   
    private $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $faker->seed(1337);
        //Boucle qui génère des faux utilisateurs
        for ($i = 1; $i < 30; $i++) {
            $user = new User();
            // Faker crée une fausse email
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_USER']);
            //Mot de passe choisis pour tous les utilisateurs Faker
            $user->setPassword($this->encoder->encodePassword($user,'azerty'));
            $manager->persist($user);
// Enregistre un utilisateur dans une reference
        $this->addReference('user_'.$i, $user);
        }

        $manager->flush();
    }
}