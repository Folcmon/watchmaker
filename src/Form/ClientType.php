<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Imię i nazwisko',
                'attr' => ['placeholder' => 'Imię i nazwisko'],
                'required' => false,
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Telefon',
                'attr' => ['placeholder' => 'Telefon']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adres e-mail',
                'attr' => ['placeholder' => 'Adres e-mail'],
                'required' => false,
            ])
            ->add('isCompany', CheckboxType::class, [
                'required' => false,
                'label' => 'Klient firmowy',
                'attr' => ['placeholder' => 'Klient firmowy']
            ])
/*            ->add('company', CompanyType::class, [
                'label' => 'Dane firmy',
                'row_attr' => ['class' => 'client_company_section'],
                'required' => false
            ])*/;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
