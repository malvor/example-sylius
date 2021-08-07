<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Product\ProductAdditionalOption;
use Sylius\Bundle\MoneyBundle\Form\Type\MoneyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class ProductAdditionalOptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'sylius.ui.name'
                ]
            )
            ->add(
                'price',
                MoneyType::class,
                [
                    'label' => 'sylius.ui.price',
                    'currency' => $options['currency'],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('data_class', ProductAdditionalOption::class)
            ->setDefault('validation_groups', ['sylius'])
            ->setRequired(['currency'])
            ->setAllowedTypes('currency', 'string')
            ->setDefaults(
                [
                    'currency' => 'PLN'
                ]
            );
    }

    public function getBlockPrefix(): string
    {
        return 'app_product_additional_option';
    }
}
