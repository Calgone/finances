<?php

namespace App\Form\Bourse;

use App\Entity\Bourse\Alerte;
use App\Entity\Bourse\AlerteModele;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlerteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('creeLe')
            ->add('dateDebut')
            ->add('date_fin')
            ->add('methode')
            ->add('seuilBas')
            ->add('seuilHaut')
            ->add('referentiel')
            ->add('variation')
            ->add('intervalle')
            ->add('alerteModele', EntityType::class, [
                'class' => AlerteModele::class,
                'choice_label' => function(AlerteModele $alerteModele) {
                    return sprintf('(%d) %s', $alerteModele->getId(), $alerteModele->getTitre());
                },
                'placeholder' => 'Choisir un modèle'
            ])
//            ->add('action')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Alerte::class,
        ]);
    }
}
