<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Company;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name'
                , TextType::class, [
                    'label' => 'Nazwa Firmy',
                    'attr' => ['placeholder' => 'Nazwa Firmy']
                ])
            ->add('address', TextType::class, [
                'label' => 'Adres',
                'attr' => ['placeholder' => 'Adres']
            ])
            ->add('taxId', TextType::class, [
                'label' => 'NIP',
                'attr' => ['placeholder' => 'NIP']
            ])
            ->add('phone', TextType::class, [
                'label' => 'Telefon',
                'attr' => ['placeholder' => 'Telefon']
            ])
            ->add('email', TextType::class, [
                'label' => 'Adres e-mail',
                'attr' => ['placeholder' => 'Adres e-mail']
            ])
            ->add('bankAccount', TextType::class, [
                'label' => 'Numer konta bankowego',
                'attr' => ['placeholder' => 'Numer konta bankowego']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
