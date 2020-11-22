<?php

namespace App\DataFixtures;

use App\Entity\Bourse\AlerteModele;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AlerteModeleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $am1 = (new AlerteModele())
            ->setTitre("Le cours franchit un seuil à la hausse ou à la baisse");

        $manager->persist($am1);

        $am2 = (new AlerteModele())
            ->setTitre("Variation en % du cours par rapport à un référentiel (veille / ouverture...)");
        $manager->persist($am2);

        $am3 = (new AlerteModele())
            ->setTitre("Le cours sort d'un tunnel compris entre deux bornes");
        $manager->persist($am3);

        $am4 = (new AlerteModele())
            ->setTitre("Le volume du jour est supérieur de x% à la moyenne des volumes sur y jours");
        $manager->persist($am4);

        $am5 = (new AlerteModele())
            ->setTitre("Le cours croise sa moyenne mobile 20/50/100 à la hausse ou à la baisse");
        $manager->persist($am5);

        $am6 = (new AlerteModele())
            ->setTitre("Le cours franchit son plus haut ou son plus bas depuis [référentiel]");
        $manager->persist($am6);

        $manager->flush();

    }
}
