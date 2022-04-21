<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Form;

use Pidia\Apps\Demo\Entity\AnalisisSensorial;
use Pidia\Apps\Demo\Security\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;




class AnalisisSensorialType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('periodo')
            ->add('fecha', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('certificacion')
            ->add('tikect', ChoiceType::class, [
                'mapped' => false,
            ])

            ->add('puntaje')
            ->add('fragrancia')
            ->add('sabor')
            ->add('saborResidual')
            ->add('acidez')
            ->add('cuerpo')
            ->add('balance')
            ->add('puntajeCatador')
            ->add('descripcion')
            ->add('uniformidad')
            ->add('tasaLimpia')
            ->add('dulzor');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AnalisisSensorial::class,
        ]);
    }
}
