<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setFirstName('Grégory');
        $user->setLastName('Lecubin');
        $user->setEmail('gregory.lecubin@gmail.com');

        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'password123'
        ));
        $manager->persist($user);
        $manager->flush();
    }
}
