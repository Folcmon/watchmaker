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
            ->add('device_type', TextType::class, [
                'label' => 'Rodzaj sprzętu',
                'required' => true,
                'attr' => ['class' => 'form-control'],
                'data' => 'Zegarek'
            ])
            ->add('brand', TextType::class, [
                'label' => 'Marka',
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('model', TextType::class, [
                'label' => 'Model',
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('serial_number', TextType::class, [
                'label' => 'Numer seryjny',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('fault_description', TextareaType::class, [
                'label' => 'Opis usterki',
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('customer_name', TextType::class, [
                'label' => 'Dane klienta',
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('customer_phone', TextType::class, [
                'label' => 'Telefon',
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('date_received', DateType::class, [
                'label' => 'Data przyjęcia',
                'widget' => 'single_text',
                'required' => true,
                'attr' => ['class' => 'form-control']
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
