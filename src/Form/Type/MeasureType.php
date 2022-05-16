<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Form\Type;

use Pidia\Apps\Demo\Security\Security;
use Pidia\Apps\Demo\Entity\ValueObject\Measure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MeasureType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('valor')
            ->add('unidad', ChoiceType::class, [
                'choices' => [
                    'Kilogramo' => 'Kg',
                    'Quintal' => 'Qt',
                    'Gramos' => 'Gr',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Measure::class,
        ]);
    }
}
