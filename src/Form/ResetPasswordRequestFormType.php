<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ResetPasswordRequestFormType extends AbstractType
{
    /**
     * Fonction qui contient tous les attributs à utiliser pour créer le formulaire de demande de réinitialisation.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [ // Ajout de l'attribut email.
                'attr' => ['autocomplete' => 'email'],
                'constraints' => [
                    // Ne doit pas etre vide.
                    new NotBlank([
                        'message' => 'Please enter your email',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
