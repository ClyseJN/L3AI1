<?php

namespace App\Form;

use App\Entity\Competence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CompetenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('type',ChoiceType::class, [
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
            ->add('title',TextType::class,[
                'label'=> 'Titre',
            ])
            ->add('content',TextareaType::class,[
                'label'=> 'Description',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Competence::class,
        ]);
    }
}
