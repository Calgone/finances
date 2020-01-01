<?php

namespace App\Form;

use App\Entity\Immo\Projet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('net_vendeur')
            ->add('frais_agence')
            ->add('frais_notaire')
            ->add('travaux')
            ->add('meubles')
            ->add('apport')
            ->add('credit_frais_dossier')
            ->add('tx_emprunt')
            ->add('tx_emprunt_ass')
            ->add('credit_duree_mois')
            ->add('credit_date_debut')
            ->add('loyer_cible_hc')
            ->add('taxe_fonciere')
            ->add('charges_non_recup')
            ->add('cout_assurance_bien')
            ->add('cout_travaux_entretiens')
            ->add('cout_comptable')
            ->add('cout_gestion_locative')
            ->add('cout_autre')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projet::class,
        ]);
    }
}
