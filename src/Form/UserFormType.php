<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control my-2'
                ],
                'label' => 'Почта',
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 5, 64)
                ]
            ])
            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'form-control my-2'
                ],
                'label' => 'Имя',
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 5, 32)
                ]
            ])
            ->add('lastName', TextType::class, [
                'attr' => [
                    'class' => 'form-control my-2'
                ],
                'label' => 'Фамилия',
                'constraints' => [
                    new NotBlank(),
                    new Length(null, 5, 32)
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Сохранить',
                'attr' => [
                    'class' => 'btn btn-primary my-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => [
                'id' => 'user_profile_form'
            ]
        ]);
    }
}
