<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Form;

use Doctrine\ORM\EntityRepository;
use Pidia\Apps\Demo\Entity\Acopio;
use Pidia\Apps\Demo\Form\Type\MeasureType;
use Pidia\Apps\Demo\Security\Security;
use Symfony\Component\Form\AbstractType;
use Pidia\Apps\Demo\Entity\AnalisisFisico;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class AnalisisFisicoType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var AnalisisFisico $analisisFisico */
        $analisisFisico = $builder->getData();
        $builder
            ->add('fecha', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('certificacion')
            ->add('acopio', EntityType::class, [
                'class' => Acopio::class,
                'query_builder' => function (EntityRepository $er) use ($analisisFisico) {
                    if (null === $analisisFisico->getId()) {
                        return $er->createQueryBuilder('acopio')
                            ->where('acopio.analisis_Fisico = false')
                            ->andWhere('acopio.activo=true')
                            ->orderBy('acopio.tikect', 'ASC');
                    }
                    return $er->createQueryBuilder('acopio')
                        ->where('acopio.analisis_Fisico = false')
                        ->andWhere('acopio.activo=true')
                        ->OrWhere('acopio.id = :acopioId')
                        ->setParameter('acopioId', $analisisFisico->getAcopio()?->getId())
                        ->orderBy('acopio.tikect', 'ASC')
                        ->orderBy('acopio.tikect', 'ASC');
                },
                'choice_label' => 'tikect',
            ])
            ->add('muestra', ChoiceType::class, [
                'choices' => [
                    '300' => 300,
                    '400' => 400,
                ],
            ])


            ->add('exportable', null, [
                'label' => 'Exportable % :',
            ])
            ->add('exportable_', null, [
                'label' => 'Exportable:',
            ])
            ->add('bola', null, [
                'label' => 'Exportable % :',
            ])
            ->add('bola_', null, [
                'label' => 'Bola:',
            ])
            ->add('segunda', null, [
                'label' => 'Exportable % :',
            ])
            ->add('segunda_', null, [
                'label' => 'Segunda:',
            ])
            ->add('cascara', null, [
                'label' => 'Exportable % :',
            ])
            ->add('cascara_', null, [
                'label' => 'Cascara:',
            ])
            ->add('humedad')
            ->add('descripcion')
            ->add('tipo', MeasureType::class, [
                'required' => false,
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AnalisisFisico::class,
        ]);
    }
}
