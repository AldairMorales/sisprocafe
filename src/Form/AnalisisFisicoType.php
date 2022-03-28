<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Form;

use Doctrine\ORM\EntityRepository;
use Pidia\Apps\Demo\Entity\AnalisisFisico;
use Pidia\Apps\Demo\Security\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
<<<<<<< HEAD
=======
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

>>>>>>> 94cd187dc4e5223514658f355b9c0f5640cac217

class AnalisisFisicoType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('certificacion')
            ->add('tikect', ChoiceType::class, [
                'mapped' => false,
            ])
            ->add('muestra', ChoiceType::class, [
                'choices' => [
<<<<<<< HEAD
                    '100' => 1,
                    '300' => 2,
                    '400' => 3,
                ],
=======
                    '100' => 100,
                    '200' => 200,
                    '300' => 300
                ]
>>>>>>> 94cd187dc4e5223514658f355b9c0f5640cac217
            ])

            // ->add('unidadMedida', EntityType::class, [
            //     'mapped' => false,
            //     'class' => UnidadMedida::class,
            //     'query_builder' => function (EntityRepository $er) {
            //         return $er->createQueryBuilder('u')
            //             ->orderBy('u.nombre', 'ASC');
            //     },
            //     'choice_label' => 'nombre',
            // ])
            ->add('exportable')
            ->add('exportable_', null, [
                'mapped' => false,
                'label' => 'Exportable % :',
            ])
            ->add('bola')
            ->add('bola_', null, [
                'mapped' => false,
                'label' => 'Bola % :',
            ])
            ->add('segunda')
            ->add('segunda_', null, [
                'mapped' => false,
                'label' => 'Segunda % :',
            ])
            ->add('cascara')
            ->add('cascara_', null, [
                'mapped' => false,
                'label' => 'Cascara % :',
            ])

            ->add('humedad')
            ->add('descripcion');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AnalisisFisico::class,
        ]);
    }
}
