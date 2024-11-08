<?php

namespace App\Form;

use App\Entity\Order;
use App\Enum\OrderStatusEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('labor', NumberType::class)
            ->add('description', TextAreaType::class)
            ->add('client')
            ->add('status', ChoiceType::class, [
                'choices' => OrderStatusEnum::getChoices(),
                'label' => 'Status',
            ])
            ->add('serviceAttachments', FileType::class, ['multiple' => true, 'mapped' => false, 'required' => false])
            ->add('usedParts', CollectionType::class, [
                'attr' => ['class' => 'usedParts-collection form-inline'],
                'label' => false,
                'entry_type' => UsedPartType::class,
                'mapped' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }

}
