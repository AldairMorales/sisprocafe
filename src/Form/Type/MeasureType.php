<?php

/*
 * This file is part of the PIDIA.
 * (c) Carlos Chininin <cio@pidia.pe>
 */

namespace Pidia\Apps\Demo\Form\Type;

use Pidia\Apps\Demo\Security\Security;
use Pidia\Apps\Demo\Entity\UnidadMedida;
use Symfony\Component\Form\AbstractType;
use Pidia\Apps\Demo\Entity\ValueObject\Measure;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

class MeasureType extends AbstractType implements DataMapperInterface
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('valor')
            ->add('unidad', ChoiceType::class, [
                'choices' => $this->units($options['category']),
            ])
            ->setDataMapper($this);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Measure::class,
            'empty_data' => null,
            'category' => null,
        ]);
    }

    /** @param Measure $viewData */
    public function mapDataToForms(mixed $viewData, \Traversable $forms)
    {
        // there is no data yet, so nothing to prepopulate
        if (null === $viewData) {
            return;
        }

        // invalid data type
        if (!$viewData instanceof Measure) {
            throw new UnexpectedTypeException($viewData, Measure::class);
        }

        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        // initialize form field values
        $forms['valor']->setData($viewData->valor());
        $forms['unidad']->setData($viewData->unidad());
    }

    public function mapFormsToData(\Traversable $forms, mixed &$viewData)
    {
        /** @var FormInterface[] $forms */
        $forms = iterator_to_array($forms);

        // as data is passed by reference, overriding it will change it in
        // the form object as well
        // beware of type inconsistency, see caution below
        $viewData = null;
        if (null !== $forms['valor']->getData()) {
            $viewData = new Measure(
                (float) $forms['valor']->getData(),
                $forms['unidad']->getData(),
            );
        }
    }

    private function units(mixed $category): array
    {
        if ('envase' === $category) {
            return [
                'Sacos' => 'sc',
                'Baldes' => 'bl',
            ];
        }

        return [
            'Kilogramos' => 'kg',
            'Libras' => 'lb',
            'Quintal' => 'Qq',
        ];
    }
}
