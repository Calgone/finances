<?php

namespace App\Form\Bourse;

use App\Entity\Bourse\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateTimeType::class, [
                'label' => 'Passé le',
                'date_widget' => 'single_text'
            ])
            ->add('label')
            ->add('isin')
            ->add('direction')
            ->add('state')
            ->add('volume')
            ->add('type')
            ->add('quotation')
            ->add('validity')
            ->add('exchange')
            ->add('brokerFee')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
