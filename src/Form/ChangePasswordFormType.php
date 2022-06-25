<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordFormType extends AbstractType
{
    /**
     * Fonction qui contient tous les attributs à utiliser pour créer le formulaire de réinitialisation.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => ['autocomplete' => 'new-password'],
                    'constraints' => [
                        //Le mot de passe ne doit pas etre vide.
                        new NotBlank([
                            'message' => 'Please enter a password',
                        ]),
                        new Length([
                            //Taille minimale du mot de passe.
                            'min' => 6,
                            //Message affiché dans le cas contraire.
                            'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} characteres',
                            // Taille maximale imposée par symfony pour des raisons de sécurité.
                            'max' => 4096,
                        ]),
                    ],// Text afficé pour le premier label
                    'label' => 'Nouveau mot de passe',
                ],
                'second_options' => [
                    'attr' => ['autocomplete' => 'new-password'],
                    // Texte affiché pour le 2eme label (Répétition du mot de passe).
                    'label' => 'Confirmer votre mot de passe ',
                ],
                'invalid_message' => 'Les 2 champs doivent être identiques',
                // Instead of being set onto the object directly, this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
