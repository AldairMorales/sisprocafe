<?php

namespace Pidia\Apps\Demo\Form;

use Pidia\Apps\Demo\Entity\Producto;
use Symfony\Component\Form\AbstractType;
use Pidia\Apps\Demo\Entity\DetallePeriodo;
use Pidia\Apps\Demo\Form\Type\MeasureType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetallePeriodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'producto',
                EntityType::class,
                [
                    'class' => Producto::class,
                ],
            )
            ->add('humedadInicial')
            ->add('tara', MeasureType::class, [
                'required' => false,
            ])
            ->add('muestra', MeasureType::class, [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DetallePeriodo::class,
        ]);
    }
}
