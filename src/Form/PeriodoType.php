<?php

namespace Pidia\Apps\Demo\Form;

use Pidia\Apps\Demo\Entity\Periodo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PeriodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('alias')
            ->add('estado', ChoiceType::class, [
                'choices' => [
                    'Abierto' => 'Abierto',
                    'Cerrado' => 'Cerrado',
                ],
            ])
            ->add('descripcion')
            ->add('fechaInicio', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('fechaFinal', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('detalles', CollectionType::class, [
                'entry_type' => DetallePeriodoType::class,
                'entry_options' => ['label' => false],
                'label' => 'Detalle Producto',
                'allow_add' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Periodo::class,
        ]);
    }
}
