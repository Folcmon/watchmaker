<?php

namespace App\Form;

use App\Entity\Storage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StorageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
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
            ->add('vat', NumberType::class, [
                'label' => 'Kwota podatku VAT w procentach',
                'scale' => 0,
                'html5' => true
            ])
            ->add('margin', NumberType::class, [
                'label' => 'Kwota marży w procentach',
                'scale' => 0,
                'html5' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Storage::class,
        ]);
    }
}
