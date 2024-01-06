<?php

namespace App\Form;

use App\Entity\Category;
use App\Enums\CommonStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Название',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Статус',
                'choices' => [
                    'Активно' => CommonStatus::ACTIVE->value,
                    'Выключено' => CommonStatus::DISABLED->value
                ],
                'attr' => [
                    'class' => 'form-select'
                ]
            ])
            ->add('text', TextareaType::class, [
                'label' => 'Текст',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('updated', DateTimeType::class, [
                'label' => 'Создано',
                'attr' => [
                    'class' => 'form-control'
                ],
                'disabled' => true
            ])
            ->add('created', DateTimeType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Обновлено',
                'disabled' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
