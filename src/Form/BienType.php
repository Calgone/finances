<?php

namespace App\Form;

use App\Entity\Immo\Bien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresse')
            ->add('cp')
            ->add('ville')
            ->add('an_construction')
            ->add('an_achat')
            ->add('date_mise_vente')
            ->add('proprio_nom')
            ->add('proprio_age')
            ->add('vente_motif')
//            ->add('creeLe')
            ->add('vendu_le')
            ->add('prix_net_vendeur')
            ->add('frais_agence')
            ->add('titre')
            ->add('description');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bien::class,
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
