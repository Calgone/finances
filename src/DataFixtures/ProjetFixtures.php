<?php

namespace App\DataFixtures;

use App\Entity\Immo\Bien;
use App\Entity\Immo\Lot;
use App\Entity\Immo\Projet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class ProjetFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Faker\Factory::create('fr_FR');

        // On crée 10 projets, qui contiennent chacun 10 biens différents qui ont entre 1 et 5 lots chacun
        for ($i = 0; $i < 10; $i++) {
            $projet = new Projet();
            $netVendeur = random_int(50000, 150000);
            $loyerCible = $netVendeur / 12 / 100;
            $projet->setNetVendeur($netVendeur)
                ->setFraisAgence($netVendeur * 0.1)
                ->setFraisNotaire($netVendeur * 0.08)
                ->setTravaux(random_int(0, 30000))
                ->setMeubles(random_int(0,5000))
                ->setApport(random_int(0, $netVendeur * 0.15))
                ->setCreditFraisDossier(random_int(1000,2000))
                ->setCreditGarantie(random_int(0, $netVendeur * 0.02))
                ->setCreditTaux(random_int(10, 20)  / 10)
                ->setCreditTauxAss(0.36)
                ->setCreditDureeMois(240)
                ->setCreditDateDebut(new \DateTime('first day of next month'))
                ->setLoyerCibleHc($netVendeur / 12 / 100)
                ->setTaxeFonciere($loyerCible)
                ->setChargesNonRecup(random_int(0,1000))
                ->setCoutAssuranceBien(random_int(50,200))
                ->setCoutTravauxEntretiens(random_int(0,500))
                ->setCoutComptable(random_int(0,300))
                ->setCoutGestionLocative(0, $loyerCible * 0.1)
                ->setCoutAutre(random_int(0,500));

            $bien = new Bien();
            $bien->setBienType(random_int(1, count($bien::TYPE)))
                ->setAdresse($faker->streetAddress)
                ->setCp($faker->postcode)
                ->setVille($faker->city)
                ->setAnConstruction(random_int(1930, 2020))
                ->setAnAchat(random_int(1980, 2020))
                ->setDateMiseVente($faker->dateTime)
                ->setProprioNom($faker->name)
                ->setProprioAge(random_int(25,90))
                ->setVenteMotif('vente')
                ->setPrixNetVendeur($netVendeur)
                ->setFraisAgence($projet->getFraisAgence())
                ->setTitre($faker->sentence(3))
                ->setDescription($faker->sentence);
            $manager->persist($bien);

            $projet->setBien($bien);
            $manager->persist($projet);

            for ($j = 0; $j < 5; $j++) {
                $lot = new Lot();
                $lot->setBien($bien)
                    ->setChauffageType(random_int(0,6))
                    ->setSurface(random_int(20,150))
                    ->setLotType(random_int(0, count($lot::TYPE) - 1));
                $manager->persist($lot);
            }
    }

        $manager->flush();
    }
}
