<?php

namespace App\Form;

use App\Entity\CourseBugReport;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class BugCourseReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control mt-2'
                ],
                'label' => 'Краткое описание проблемы',
                'label_attr' => [
                    'class' => 'mt-2'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(null, '10', '255')
                ]
            ])
            ->add('text', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control mt-2',
                    'rows' => '10'
                ],
                'label' => 'Подробное описание проблемы',
                'label_attr' => [
                    'class' => 'mt-2'
                ],
                'constraints' => [
                    new NotBlank(),
                    new Length(null, '10', '1024')
                ]
            ])
            ->add('course', HiddenType::class, [
                'data' => 'id'
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-2'
                ],
                'label' => 'Отпрафить заявку на исправление',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CourseBugReport::class,
        ]);
    }
}
