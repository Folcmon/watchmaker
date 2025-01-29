<?php
// src/Form/ServiceAcceptanceFormType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderEquipmentAcceptanceProtocolType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('service_provider', TextType::class, [
                'label' => 'Wykonawca',
                'required' => true,
                'data' => 'Salon zegarmistrzowski Radosław Kasperiuk'

            ])
            ->add('service_provider_address', TextType::class, [
                'label' => 'Adres wykonawcy',
                'required' => true,
                'data' => 'Białystok . Suraska1 lok1'

            ])
            ->add('service_provider_phone', TextType::class, [
                'label' => 'Telefon wykonawcy',
                'required' => true,

            ])
            ->add('device_type', TextType::class, [
                'label' => 'Rodzaj sprzętu',
                'required' => true,

                'data' => 'Zegarek'
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
            ->add('fault_description', TextareaType::class, [
                'label' => 'Opis usterki',
                'required' => true,

            ])
            ->add('customer_name', TextType::class, [
                'label' => 'Dane klienta',
                'required' => true,

            ])
            ->add('customer_phone', TextType::class, [
                'label' => 'Telefon',
                'required' => true,

            ])
            ->add('date_received', DateType::class, [
                'label' => 'Data przyjęcia',
                'widget' => 'single_text',
                'required' => true,

                'data' => new \DateTime()
            ])/*
            ->add('save', SubmitType::class, [
        'label' => 'Zapisz protokół',
        'attr' => ['class' => 'btn btn-primary']
    ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
