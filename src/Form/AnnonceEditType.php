<?php
namespace App\Form;
use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class AnnonceEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
         ->add('status', ChoiceType::class, 
            [
                'choices' => [
                   ' Activé' =>'1',
                    'Désactivée' => '0'
                ],
            'expanded' => true,
          
            ]
        )
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
                
                'label' =>"Modifier l'annonce"
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