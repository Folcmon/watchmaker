<?php

namespace App\Form;

use App\Entity\VatRate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VatRateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rateName', TextType::class, [
                'label' => 'Nazwa Podatku',
                'attr' => ['placeholder' => 'Nazwa podatku']
            ])
            ->add('rateValue', NumberType::class, [
                'label' => 'Stawka VAT w procentach',
                'scale' => 0,
                'html5' => true
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VatRate::class,
        ]);
    }
}
