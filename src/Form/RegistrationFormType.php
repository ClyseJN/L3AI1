<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Mime\Address;
use PhpParser\Node\Attribute;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Required;
use Vtiful\Kernel\Format;
use Symfony\Component\Serializer\Annotation\MaxDepth;

class RegistrationFormType extends AbstractType
{
    /**
     * Fonction qui contient tous les attributs à utiliser pour créer le formulaire d’inscription.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class, [
                'required'=> 'true',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('firstName',TextType::class,[
                'required'=> 'true',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('lastName',TextType::class,[
                'required'=> 'true',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('birthDay', BirthdayType::class, [
                'required'=> 'true',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add('adresse',TextType::class,[
                'required'=> 'true',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('phone',TextType::class,[
                'required'=> 'true',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // Au lieu d'etre place directement sur l'objet, celui-ci est lu et encode dans le controleur
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class'=>"form-control"
                ],
                //Le mot de passe ne doit pas etre vide.
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    // Longueur minimale et maximale du mot de passe.
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // Imposé par symfony pour des raisons de sécurité.
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
