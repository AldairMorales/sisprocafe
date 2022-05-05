<?php

namespace Pidia\Apps\Demo\Form;

use Pidia\Apps\Demo\Entity\PrecioAcopio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class PrecioAcopioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('precioBase')
            ->add('rendimiento', CollectionType::class, [
                'entry_type' => RendimientoType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('certificacionValor', CollectionType::class, [
                'entry_type' => CertificacionValorType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PrecioAcopio::class,
        ]);
    }
}
