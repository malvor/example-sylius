<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Product\ProductAdditionalOptionInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class ProductAdditionalOptionsType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addEventListener(
                FormEvents::PRE_SET_DATA,
                function (FormEvent $event): void {
                    /** @var ProductAdditionalOptionInterface $organization */
                    $form = $event->getForm();

                    $form
                        ->add(
                            'additionalOptions',
                            CollectionType::class,
                            [
                                'entry_type' => ProductAdditionalOptionType::class,
                                'allow_add' => true,
                                'allow_delete' => true,
                                'by_reference' => false,
                                'label' => false,
                                'button_add_label' => 'app.ui.add_product_additional_option',
                                'entry_options' => [
                                    'currency' => 'PLN'
                                ],
                            ]
                        );
                }
            );
    }

    public function getBlockPrefix(): string
    {
        return 'app_product_additional_options';
    }
}
