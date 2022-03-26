<?php

namespace Pidia\Apps\Demo\Form;

use Pidia\Apps\Demo\Entity\Acopio;
use Pidia\Apps\Demo\Entity\Almacen;
use Pidia\Apps\Demo\Entity\Certificacion;
use Pidia\Apps\Demo\Entity\Periodo;
use Pidia\Apps\Demo\Entity\Socio;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AcopioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('periodo', EntityType::class, [
                'class' => Periodo::class,
            ],
            )
            ->add('fecha')
            ->add('socio', EntityType::class, [
                'class' => Socio::class,
            ],
            )
            ->add('certificacion', EntityType::class, [
                'class' => Certificacion::class,
            ],
            )
            ->add('almacen', EntityType::class, [
                'class' => Almacen::class,
            ],
            )
            ->add('tikect')
            ->add('pesoBruto')
            ->add('cantidad')
            ->add('taraPorSaco')
            ->add('taraDeSacos')
            ->add('pesoQuintales')
            ->add('pesoNeto')
            ->add('observaciones')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Acopio::class,
        ]);
    }
}
