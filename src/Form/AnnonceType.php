<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('type',ChoiceType::class, [
            'choices'  => [
                'Proposer de l\'aide' => 'Proposer de l\'aide',
                'Demander de l\'aide' => 'Demander de l\'aide',
            
            ],

        ])
       
        ->add('domaine',ChoiceType::class, [
            'label'=> 'Domaine',
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
        ->add('location',TextType::class,[
            'required' =>true,
            'label'=>'Votre adresse',
        ]) 
       
        ->add('title',TextType::class,[
                'required' =>true,
                'label'=>'Titre de l\'annonce',
                
                
            ])
            
            ->add('content',TextareaType::class,[
                'required' =>true,
                'label'=>'Votre annonce',
                
            ])
            ->add('save',SubmitType::class,[
                
                'label' =>"publier"
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
