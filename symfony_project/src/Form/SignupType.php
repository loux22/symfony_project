<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class SignupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'placeholder' => "Entrez votre nom d'utilisateur",
                    'class' => "input100",
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe n\'est pas confirmé.',

                'first_options' => [
                    'label' => 'Password',
                    'attr' => [
                        'placeholder' => "Entrez votre mot de passe",
                        'class' => "input100",
                    ]
                ],

                'second_options' => [
                    'label' => 'Repeated',
                    'attr' => [
                        'placeholder' => "Répetez votre mot de passe",
                        'class' => "input100",
                    ]
                ]
            ])

            ->add('username', TextType::class, [
                'attr' => [
                    'placeholder' => "Entrez votre nom d'utilisateur",
                    'class' => "input100",
                ]
            ])

            ->add('email', EmailType::class,[
                'attr' => [
                    'placeholder' => "Entrez votre email",
                    'class' => "input100",
                ]
            ])

            ->add('file', FileType::class,[
                'required' => false,
                ])
                   
            ->add('inscription',SubmitType::class,[
                'attr' => [
                    'placeholder' => "Valider",
                    'class' => "login100-form-btn",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
