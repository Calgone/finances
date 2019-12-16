<?php

namespace App\Form;

use App\Entity\Immo\Lot;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('surface')
            ->add('chauffageType', ChoiceType::class, [
                'choices' => $this->getChoix(Lot::CHAUFFAGE)
            ])
//            ->add('type')
//            ->add('bien')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lot::class,
        ]);
    }

    public function getChoix(array $choix): array
    {
        $output = [];
        foreach ($choix as $k => $v) {
            $output[$v] = $k;
        }
        return $output;
    }
}
