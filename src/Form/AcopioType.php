<?php

namespace Pidia\Apps\Demo\Form;

use Pidia\Apps\Demo\Entity\Socio;
use Pidia\Apps\Demo\Entity\Acopio;
use Pidia\Apps\Demo\Entity\Almacen;
use Pidia\Apps\Demo\Entity\Periodo;
use Symfony\Component\Form\AbstractType;
use Pidia\Apps\Demo\Entity\Certificacion;
use Pidia\Apps\Demo\Form\Type\MeasureType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class AcopioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'periodo',
                EntityType::class,
                [
                    'class' => Periodo::class,
                ],
            )
            ->add('fecha', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add(
                'socio',
                EntityType::class,
                [
                    'class' => Socio::class,
                ],
            )
            ->add(
                'certificacion',
                EntityType::class,
                [
                    'class' => Certificacion::class,
                ],
            )
            ->add(
                'almacen',
                EntityType::class,
                [
                    'class' => Almacen::class,
                ],
            )
            ->add('tikect')
            ->add('pesoBruto', MeasureType::class, [
                'required' => false,
            ])
            ->add('cantidad', MeasureType::class, [
                'category' => 'envase',
                'required' => false,
            ])
            ->add('taraPorSaco')
            ->add('taraDeSacos', MeasureType::class, [
                'required' => false,

            ])
            ->add('pesoQuintales', MeasureType::class, [
                'required' => false,
            ])
            ->add('pesoNeto', MeasureType::class, [
                'required' => false,
            ])
            ->add('observaciones');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Acopio::class,
        ]);
    }
}
