<?php

namespace App\DataFixtures;

use App\Entity\Bank\Bank;
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

        $bourso = new Bank();
        $bourso->setName('Boursorama')
            ->setAddress('44 rue Traversière, CS 80134')
            ->setCp('92772 ')
            ->setCity('BOULOGNE BILLANCOURT CEDEX')
            ->setCountry('France');
        $bnp = new Bank();
        $bnp->setName('BNP Paribas')
            ->setAddress('16, bd des Italiens')
            ->setCountry('France')
            ->setCp('75009')
            ->setCity('PARIS');
        $manager->persist($bnp);
        $manager->persist($bourso);
        $manager->flush();
    }
}
