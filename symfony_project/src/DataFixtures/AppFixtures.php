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
            $message->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent dictum fermentum sodales. Etiam mattis turpis eu metus condimentum, ut vestibulum sem cursus. Nunc fringilla turpis risus, vel iaculis odio pretium vitae. Quisque eget dictum mauris. Suspendisse vestibulum leo aliquam sodales cursus. Etiam a ullamcorper orci, eu rhoncus magna. Quisque a auctor ante. Duis euismod ultrices ultricies. Nulla lobortis diam in faucibus facilisis. Proin at dictum nunc. In vitae ultricies ligula.');
            $message->setState(0);
            $message->setDate(new \DateTime('now'));
            $manager->persist($message);
        }

        $manager->flush();
    }
}
