<?php

namespace Pidia\Apps\Demo\Form;

use Pidia\Apps\Demo\Entity\Traslado;
use Symfony\Component\Form\AbstractType;
use Pidia\Apps\Demo\Form\DetalleTrasladoType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class TrasladoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fechaSalida', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('numeroGuia')
            ->add('almacenOrigen')
            ->add('almacenDestino')
            ->add('detalleTraslado', CollectionType::class, [
                'entry_type' => DetalleTrasladoType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Traslado::class,
        ]);
    }
}
