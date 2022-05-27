<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Form;

use Doctrine\ORM\EntityRepository;
use Pidia\Apps\Demo\Entity\Acopio;
use Pidia\Apps\Demo\Security\Security;
use Symfony\Component\Form\AbstractType;
use Pidia\Apps\Demo\Entity\AnalisisFisico;

use Pidia\Apps\Demo\Form\Type\MeasureType;
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
            ->add('muestra', MeasureType::class, [
                'required' => false,
            ])
            ->add('exportable', MeasureType::class, [
                'required' => false,
            ])
            ->add('exportableP', null, [
                'label' => 'Exportable %:',
            ])
            ->add('bola', MeasureType::class, [
                'required' => false,
            ])
            ->add('bolaP', null, [
                'label' => 'Bola % :',
            ])
            ->add('segunda', MeasureType::class, [
                'required' => false,
            ])
            ->add('segundaP', null, [
                'label' => 'Segunda % :',
            ])
            ->add('cascara', MeasureType::class, [
                'required' => false,
            ])
            ->add('cascaraP', null, [
                'label' => 'Cascara % :',
            ])
            ->add('humedad')
            ->add('descripcion');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AnalisisFisico::class,
        ]);
    }
}
