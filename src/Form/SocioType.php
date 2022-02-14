<?php

namespace Pidia\Apps\Demo\Form;


use Pidia\Apps\Demo\Entity\Socio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fechaIngreso', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('codigo')
            ->add('tipo', ChoiceType::class, [
                'choices' => [
                  'Natural' => true,
                    'Juridico' => false,
                ],
            ])
            ->add('nombres')
            ->add('apellidoPaterno')
            ->add('apellidoMaterno')
            ->add('sexo', ChoiceType::class, [
                'choices' => [
                    'Masculino' => true,
                    'femenino' => false,
                ],
            ])
            ->add('numeroDocumento')
            ->add('telefono')
            ->add('fechaNacimiento', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('conyugueNombre')
            ->add('conyugueDocumento')
            ->add('ruc')
            ->add('estadoRuc', ChoiceType::class, [
                'choices' => [
                    'Activo' => true,
                    'Inactivo' => false,
                ],
            ])
            ->add('estado')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Socio::class,
        ]);
    }
}
