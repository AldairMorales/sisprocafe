<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Form;

use Doctrine\ORM\EntityRepository;
use Pidia\Apps\Demo\Entity\AnalisisSensorial;
use Pidia\Apps\Demo\Entity\Acopio;
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
        $builder
            ->add('periodo')
            ->add('fecha', DateType::class, [
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('certificacion')
            ->add('acopio', EntityType::class, [
                'class' => Acopio::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('acopio')
                        ->where('acopio.analisis_Fisico = true')
                        ->andWhere('acopio.analisis_Sensorial=false')
                        ->orderBy('acopio.tikect', 'ASC');
                },
                'choice_label' => 'tikect',
            ])

            ->add('puntaje')
            ->add('fragrancia')
            ->add('sabor')
            ->add('saborResidual')
            ->add('acidez')
            ->add('cuerpo')
            ->add('balance')
            ->add('puntajeCatador')
            ->add('descripcion')
            ->add('uniformidad')
            ->add('tasaLimpia')
            ->add('dulzor');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AnalisisSensorial::class,
        ]);
    }
}
