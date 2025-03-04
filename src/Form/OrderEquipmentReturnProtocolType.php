<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderEquipmentReturnProtocolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('service_provider', TextType::class, [
                'label' => 'Wykonawca',
                'required' => true,
                'data' => 'Salon zegarmistrzowski Radosław Krzysztof Kasperiuk'
            ])
            ->add('service_provider_address', TextType::class, [
                'label' => 'Adres wykonawcy',
                'required' => true,
                'data' => 'Białystok, Suraska 1 lok 1'
            ])
            ->add('service_provider_phone', TextType::class, [
                'label' => 'Telefon wykonawcy',
                'required' => true,
                'data' => '693 980 385'
            ])
            ->add('customer_name', TextType::class, [
                'label' => 'Imię i nazwisko',
                'required' => true,
            ])
            ->add('customer_address', TextType::class, [
                'label' => 'Adres',
                'required' => true,
            ])
            ->add('customer_phone', TextType::class, [
                'label' => 'Telefon kontaktowy',
                'required' => true,
            ])
            ->add('device_type', TextType::class, [
                'label' => 'Rodzaj urządzenia',
                'required' => true,
            ])
            ->add('brand', TextType::class, [
                'label' => 'Marka',
                'required' => true,
            ])
            ->add('model', TextType::class, [
                'label' => 'Model',
                'required' => true,
            ])
            ->add('serial_number', TextType::class, [
                'label' => 'Numer seryjny',
                'required' => false,
            ])
            ->add('accessories', TextareaType::class, [
                'label' => 'Akcesoria przekazane wraz ze sprzętem',
                'required' => false,
            ])
            ->add('service_description', TextareaType::class, [
                'label' => 'Opis wykonanej usługi',
                'required' => true,
            ])
            ->add('equipment_condition', ChoiceType::class, [
                'label' => 'Stan sprzętu po serwisie',
                'choices' => [
                    'Sprzęt sprawny, gotowy do użytku' => 'Sprzęt sprawny, gotowy do użytku',
                    'Naprawa częściowa – wymaga dalszych działań' => 'Naprawa częściowa – wymaga dalszych działań',
                    'Sprzęt nienaprawialny' => 'Sprzęt nienaprawialny',
                ],
                'expanded' => true,
                'multiple' => false,
                'required' => true,
            ])
            ->add('remarks', TextareaType::class, [
                'label' => 'Uwagi',
                'required' => false,
            ])
            ->add('date_returned', DateType::class, [
                'label' => 'Data odbioru',
                'widget' => 'single_text',
                'required' => true,
                'data' => new \DateTime()
            ])
            ->add('customer_signature', TextType::class, [
                'label' => 'Podpis klienta',
                'required' => true,
            ])
            ->add('service_provider_signature', TextType::class, [
                'label' => 'Podpis pracownika serwisu',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}