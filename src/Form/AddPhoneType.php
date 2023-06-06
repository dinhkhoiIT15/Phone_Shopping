<?php

namespace App\Form;

use App\Entity\Phone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddPhoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('phone_name',TextType::class)
            ->add('supplier_id',TextType::class)
            ->add('price',TextType::class)
            ->add('date',DateType::class,['widget' => 'choice',])
            ->add('product_id',TextType::class)
            ->add('product',TextType::class)
            ->add('suppliers',TextType::class)
            ->add('sale',TextType::class)
            ->add('submit', SubmitType::class,['label'=>'Save', 'attr'=>['class'=>'btn-success']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Phone::class,
        ]);
    }
}
