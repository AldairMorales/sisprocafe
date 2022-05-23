<?php

namespace Pidia\Apps\Demo\Form;

use Pidia\Apps\Demo\Entity\Acopio;
use Pidia\Apps\Demo\Entity\Almacen;
use Pidia\Apps\Demo\Entity\Certificacion;
use Pidia\Apps\Demo\Entity\Periodo;
use Pidia\Apps\Demo\Entity\Socio;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModifiAcopioType extends AbstractType
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
            ->add(
                'socio',
                EntityType::class,
                [
                    'class' => Socio::class,
                ],
            )
            ->add('tikect')
            ->add('pesoNeto')
            ->add('pesoQuintales');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Acopio::class,
        ]);
    }
}
