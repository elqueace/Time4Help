<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType as SymfonyDateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
                'label' => 'Adresse e-mail',
                'attr' => array(
                    'placeholder' => 'Adresse e-mail'
                )
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
            ->add('birthday', SymfonyDateType::class, array(
                'label' => 'Date d\'anniversaire'
            ))
            ->add('gender', ChoiceType::class, array(
                'label' => 'Sexe',
                'choices' => [
                    'Non défini' => null,
                    'Homme' => true,
                    'Femme' => false
                ]
            ))
            ->add('phone', TextType::class, array(
                'label' => 'Téléphone',
                'attr' => array(
                    'placeholder' => '(+33) 01 23 45 67 89'
                )
            ))
            ->add('description', TextareaType::class, array(
                'attr' => array(
                    'placeholder' => 'Dîtes quelque chose pour vous présenter'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
