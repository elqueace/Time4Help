<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('avatar', FileType::class, array(
                'label' => 'Picture'
            ))
            ->add('pseudo', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Pseudo'
                )
            ))
            ->add('lastname', TextType::class, array(
                'label' => 'Nom',
                'attr' => array(
                    'placeholder' => 'Nom'
                )
            ))
            ->add('firstname', TextType::class, array(
                'label' => 'Prénom',
                'attr' => array(
                    'placeholder' => 'Prénom'
                )
            ))
            ->add('email', EmailType::class, array(
                'label' => 'Adresse e-mail',
                'attr' => array(
                    'placeholder' => 'Adresse e-mail'
                )
            ))
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Mot de passe',
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'attr' => array(
                    'placeholder' => 'Mot de passe'
                )
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
