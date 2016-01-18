<?php

/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 4/01/2016
 * Time: 10:42 PM
 */
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoadUserData extends Controller implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $plainPassword = 'julian';
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user1, $plainPassword);
        $user1->setUsername('julian');
        $user1->setPassword($encoded);
        $user1->setRoles(array('ROLE_ADMIN'));
        $user1->setEmail('weiyi.li713@gmail.com');

        $user2 = new User();
        $plainPassword = 'emily';
        $encoder = $this->container->get('security.password_encoder');
        $encoded = $encoder->encodePassword($user2, $plainPassword);
        $user2->setUsername('emily');
        $user2->setPassword($encoded);
        $user2->setRoles(array('ROLE_USER'));
        $user2->setEmail('julian@obee.com.au');


        $manager->persist($user1);
        $manager->persist($user2);
        $manager->flush();
    }
}