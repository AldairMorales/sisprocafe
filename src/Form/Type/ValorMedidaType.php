<?php

declare(strict_types=1);

namespace Pidia\Apps\Demo\Form\Type;

use Pidia\Apps\Demo\Form\DTO\ValorMedida;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ValorMedidaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('valor')
            ->add('unidad', ChoiceType::class, [
                'choices' => [
                    'Gramo' => 'gramo',
                    'Kilogramo' => 'kilogramo',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ValorMedida::class,
        ]);
    }
}
