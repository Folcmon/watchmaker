<?php

namespace App\Form;

use App\Entity\RealisedServiceUsedItem;
use App\Entity\Storage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsedPartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('storage', EntityType::class, [
                'class' => Storage::class,
                'placeholder' => 'Wybierz część',
                'attr' => ['class' => 'select2'],
            ])
            ->add('quantity', NumberType::class, [
                'label' => 'Ilość',
                'label_attr' => ['class' => '']
            ])
            ->add('delete', ButtonType::class, [
                'label' => 'Usuń',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RealisedServiceUsedItem::class,
        ]);
    }
}
