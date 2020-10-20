<?php

namespace App\DataFixtures;

use App\Entity\Banque\Banque;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
class BankFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Faker\Factory::create('fr_FR');

        $bourso = new Banque();
        $bourso->setNom('Boursorama')
            ->setAdresse('44 rue Traversière, CS 80134')
            ->setCp('92772 ')
            ->setVille('BOULOGNE BILLANCOURT CEDEX')
            ->setPays('France');
        $bnp = new Banque();
        $bnp->setNom('BNP Paribas')
            ->setAdresse('16, bd des Italiens')
            ->setPays('France')
            ->setCp('75009')
            ->setVille('PARIS');
        $manager->persist($bnp);
        $manager->persist($bourso);
        $manager->flush();
    }
}
