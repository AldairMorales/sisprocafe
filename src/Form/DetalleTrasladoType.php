<?php

namespace Pidia\Apps\Demo\Form;

use Pidia\Apps\Demo\Entity\Producto;
use Symfony\Component\Form\AbstractType;
use Pidia\Apps\Demo\Entity\Certificacion;
use Pidia\Apps\Demo\Form\Type\MeasureType;
use Pidia\Apps\Demo\Entity\DetalleTraslado;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetalleTrasladoType extends AbstractType
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
            ->add(
                'certificacion',
                EntityType::class,
                [
                    'class' => Certificacion::class,
                ],
            )
            ->add('peso', MeasureType::class, [
                'required' => false,
            ])
            ->add('cantidad', MeasureType::class, [
                'required' => false,
                'category' => 'envase',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DetalleTraslado::class,
        ]);
    }
}
