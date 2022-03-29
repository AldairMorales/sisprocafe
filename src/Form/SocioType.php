<?php

namespace Pidia\Apps\Demo\Form;


use Pidia\Apps\Demo\Entity\Socio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('tipo', ChoiceType::class, [
                'choices' => [
                    'Natural' => 'Natural',
                    'Juridico' => 'Juridico',
                ],
            ])
            ->add('codigo')
            ->add('nombres')
            ->add('apellidoPaterno')
            ->add('apellidoMaterno')
            ->add('sexo', ChoiceType::class, [
                'choices' => [
                    'Masculino' => 'Masculino',
                    'femenino' => 'Femenino',
                ],
            ])
            ->add('tipoDocumento', ChoiceType::class, [
                'choices' => [
                    'DNI' => 'DNI',
                    'Carné de Extranjería' => 'Carné de Extrangería',
                    'RUC' => 'RUC',
                ],
            ])
            ->add('numeroDocumento')
            ->add('telefono')
            ->add('fechaNacimiento', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('conyugueNombre')
            ->add('conyugueDocumento')
            ->add('foto', FileType::class)
            ->add('ruc')
            ->add('estadoRuc', ChoiceType::class, [
                'choices' => [
                    'Activo' => 'Activo',
                    'Inactivo' => 'Inactivo',
                ],
            ])
            ->add('estado');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Socio::class,
        ]);
    }
}
