<?php

namespace Pidia\Apps\Demo\Form;

use Doctrine\ORM\EntityRepository;
use Pidia\Apps\Demo\Entity\DetallePeriodo;
use Pidia\Apps\Demo\Entity\Producto;
use Pidia\Apps\Demo\Entity\UnidadMedida;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetallePeriodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('productos', EntityType::class, [
                'class' => Producto::class,
                ],
            )
            ->add('acciones', CheckBoxType::class, [
                'label' => 'A. Fisico',
                'required' => false,
            ])
            ->add('unidadMedida', EntityType::class, [
                'mapped' => false,
                'class' => UnidadMedida::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nombre', 'ASC');
                },
                'choice_label' => 'nombre',
            ])
            ->add('tara')
            ->add('humedadInicial')
            ->add('muestra')
            ->add('unidadMedida', ChoiceType::class, [
                'choices' => [
                    'Kilogramos' => 'Kilogramos',
                    'Quintal' => 'Quintal',
                    'Gramos' => 'Gramos',
                ],
            ])
            ->add('envase', CheckBoxType::class, [
                'label' => 'Sacos',
                'required' => true,
            ])
            ->add('moneda', ChoiceType::class, [
                'choices' => [
                    'Soles' => 'Soles',
                    'Dolares' => 'Dolares',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DetallePeriodo::class,
        ]);
    }
}
