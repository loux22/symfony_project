<?php

namespace App\DataFixtures;

use App\Entity\Groupe;
use App\Entity\Message;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        for ($i = 1; $i <= 10; $i++) {
            $user = new User;
            $user->setUsername('user' . $i);
            $user->setPassword('123456');
            $user->setPhoto('default.jpg');
            $user->setEmail('user' . $i . '@gmail.com');
            $manager->persist($user);
        }


        for ($i = 1; $i <= 10; $i++) {
            $groupe = new Groupe;
            $groupe->setNom('groupe' . $i);
            $groupe->setPhoto('default.jpg');
            $groupe->setDate(new \DateTime('now'));
            $manager->persist($groupe);
        }

        for ($i = 1; $i <= 10; $i++) {
            $message = new Message;
            $message->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent dictum fermentum sodales.');
            $message->setState(0);
            $message->setDate(new \DateTime('now'));
            $manager->persist($message);
        }

        $manager->flush();
    }
}
