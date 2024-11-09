<?php

namespace App\Form;

use App\Entity\Storage;
use App\Entity\VatRate;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StorageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nazwa przedmiotu'
            ])
            ->add('quantity', NumberType::class, [
                'label' => 'Ilość',
                'scale' => 0,
                'html5' => true
            ])
            ->add('alarmQuantity', NumberType::class, [
                'label' => 'Ilość alarmowa',
                'scale' => 0,
                'html5' => true
            ])
            ->add('price', NumberType::class, [
                'label' => 'Cena netto w zł',
                'scale' => 2,
                'html5' => true,
                'attr' => [
                    'step' => 0.01
                ]
            ])
            ->add('vatRate', EntityType::class, [
                'label' => 'Kwota podatku VAT w %',
                'class' => VatRate::class,
            ])
            ->add('margin', NumberType::class, [
                'label' => 'Kwota marży w %',
                'scale' => 0,
                'html5' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Storage::class,
        ]);
    }
}
