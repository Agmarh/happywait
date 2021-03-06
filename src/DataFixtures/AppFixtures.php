<?php

namespace App\DataFixtures;

use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('guillaumeguegan@outlook.fr');
        $manager->persist($user);

        $user = new User();
        $user->setEmail('kevin@happywait.com');
        $manager->persist($user);

        //$user = new User();
        //$user->setEmail('test@test.com');
        //$manager->persist($user);

        $manager->flush();
    }
}
