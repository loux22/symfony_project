<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Groupe;
use App\Entity\Message;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for ($i = 1; $i <= 10; $i++) {
            $user = new User;
            $user->setUsername('user' . $i);
            $user->setPassword('$argon2i$v=19$m=65536,t=4,p=1$Q2VDNDlVbjliOVl1dHJJOQ$/n2LjKxwSeZIVd+8BvS/WYVYwS5Ubq7VLamQFIZ9Wb0');
            $user->setPhoto('default.jpg');
            $user->setEmail('user' . $i . '@gmail.com');
            $manager->persist($user);
        }
        $manager->flush();
    }
}
