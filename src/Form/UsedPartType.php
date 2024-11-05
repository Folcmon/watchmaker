<?php

namespace App\Form;

use App\Entity\Storage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsedPartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('usedPart', EntityType::class, [
                'class' => Storage::class,
                'label' => 'Część',
                'label_attr' => ['class' => 'col-form-label']
            ])
            ->add('quantity', NumberType::class, [
                'label' => 'Ilość',
                'label_attr' => ['class' => 'col-form-label']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
