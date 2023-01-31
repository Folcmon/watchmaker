<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nazwa Klienta',
                'attr' => ['placeholder' => 'Nazwa Klienta']
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Telefon',
                'attr' => ['placeholder' => 'Telefon']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adres e-mail',
                'attr' => ['placeholder' => 'Adres e-mail']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
