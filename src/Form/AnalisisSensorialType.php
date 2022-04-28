<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Form;

use Doctrine\ORM\EntityRepository;
use Pidia\Apps\Demo\Entity\AnalisisSensorial;
use Pidia\Apps\Demo\Entity\Acopio;
use Pidia\Apps\Demo\Entity\DetalleAtributos;
use Pidia\Apps\Demo\Security\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;





class AnalisisSensorialType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var AnalisisSensorial $analisisSensorial */
        $analisisSensorial = $builder->getData();
        $builder
            ->add('periodo')
            ->add('fecha', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('certificacion')
            ->add('acopio', EntityType::class, [
                'class' => Acopio::class,
                'query_builder' => function (EntityRepository $er) use ($analisisSensorial) {
                    if (null === $analisisSensorial->getId()) {
                        return $er->createQueryBuilder('acopio')
                            ->where('acopio.analisis_Fisico = true')
                            ->andwhere('acopio.analisis_Sensorial = false')
                            ->andWhere('acopio.activo=true')
                            ->orderBy('acopio.tikect', 'ASC');
                    }
                    return $er->createQueryBuilder('acopio')
                        ->where('acopio.analisis_Fisico = true')
                        ->andwhere('acopio.analisis_Sensorial = false')
                        ->andWhere('acopio.activo=true')
                        ->OrWhere('acopio.id = :acopioId')
                        ->setParameter('acopioId', $analisisSensorial->getAcopio()?->getId())
                        ->orderBy('acopio.tikect', 'ASC')
                        ->orderBy('acopio.tikect', 'ASC');
                },
                'choice_label' => 'tikect',
            ])

            ->add('puntaje')
            ->add('fragrancia')
            ->add('fragranciaCategoria', EntityType::class, [
                'class' => DetalleAtributos::class,
                'required' => false,
                'label' => 'Categorias Sabor',
                'multiple' => true,
                'placeholder' => 'Seleccione ...',
                'group_by' => 'atributoCatacion',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('detalle')
                        ->select(['detalle', 'atributoCatacion'])
                        ->join('detalle.atributoCatacion', 'atributoCatacion')
                        ->where('atributoCatacion.id=2')
                        ->orderBy('detalle.nombre', 'ASC')
                        ->addOrderBy('atributoCatacion.nombre', 'ASC');
                },
            ])
            ->add('sabor')
            ->add('saborResidual')
            ->add('acidez')
            ->add('cuerpo')
            ->add('saborCategorias', EntityType::class, [
                'class' => DetalleAtributos::class,
                'required' => false,
                'label' => 'Categorias Sabor',
                'multiple' => true,
                'placeholder' => 'Seleccione ...',
                'group_by' => 'atributoCatacion',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('detalle')
                        ->select(['detalle', 'atributoCatacion'])
                        ->join('detalle.atributoCatacion', 'atributoCatacion')
                        ->where('atributoCatacion.id <=5')
                        ->andwhere('atributoCatacion.id !=2')
                        ->orderBy('detalle.nombre', 'ASC')
                        ->addOrderBy('atributoCatacion.nombre', 'ASC');
                },
            ])
            ->add('balance')
            ->add('uniformidad')
            ->add('tasaLimpia')
            ->add('dulzor')
            ->add('puntajeCatador')
            ->add('balanceCategorias', EntityType::class, [
                'class' => DetalleAtributos::class,
                'required' => false,
                'label' => 'Categorias Sabor',
                'multiple' => true,
                'placeholder' => 'Seleccione ...',
                'group_by' => 'atributoCatacion',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('detalle')
                        ->select(['detalle', 'atributoCatacion'])
                        ->join('detalle.atributoCatacion', 'atributoCatacion')
                        ->where('atributoCatacion.id >5')
                        ->orderBy('detalle.nombre', 'ASC')
                        ->addOrderBy('atributoCatacion.nombre', 'ASC');
                },
            ])
            ->add('descripcion');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AnalisisSensorial::class,
        ]);
    }
}
