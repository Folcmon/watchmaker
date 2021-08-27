<?php

namespace App\Form;

use App\Entity\RealisedService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RealisedServiceType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', TextAreaType::class)
            ->add('client')
            ->add('serviceAttachments', FileType::class, ['multiple' => true, 'mapped' => false])
            ->add('usedParts', CollectionType::class, [
                'entry_type' => UsedPartType::class,
                'mapped' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RealisedService::class,
        ]);
    }

}
