<?php

/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 4/01/2016
 * Time: 10:42 PM
 */
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LoadUserData extends Controller implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
//        $user1 = new User();
//        $plainPassword = 'julian';
//        $encoder = $this->container->get('security.password_encoder');
//        $encoded = $encoder->encodePassword($user1, $plainPassword);
//        $user1->setUsername('julian');
//        $user1->setPassword($encoded);
//        $user1->setRoles(array('ROLE_ADMIN'));
//        $user1->setEmail('weiyi.li713@gmail.com');
//
//        $user2 = new User();
//        $plainPassword = 'emily';
//        $encoder = $this->container->get('security.password_encoder');
//        $encoded = $encoder->encodePassword($user2, $plainPassword);
//        $user2->setUsername('emily');
//        $user2->setPassword($encoded);
//        $user2->setRoles(array('ROLE_USER'));
//        $user2->setEmail('julian@obee.com.au');
//
//
//        $manager->persist($user1);
//        $manager->persist($user2);
//        $manager->flush();





        $mainCategory1 = new Category();
        $mainCategory1->setName('健康品');
        $mainCategory1->setPriority(4);

        $c1 = new Category();
        $c1->setName('药物');
        $c1->setParent($mainCategory1);

        $c2 = new Category();
        $c2->setName('鱼油');
        $c2->setParent($mainCategory1);


        $product = new Product();
        $product->setName('Blackmores Vitamin E');
        $product->setPrice(14.50);
        $product->setDescription('test description');
        $product->addCategory($c1);

        $mainCategory2 = new Category();
        $mainCategory2->setName('女生用品');
        $mainCategory2->setPriority(3);

        $c3 = new Category();
        $c3->setName('睫毛膏');
        $c3->setParent($mainCategory2);

        $mainCategory3 = new Category();
        $mainCategory3->setName('电子游戏');
        $mainCategory3->setPriority(2);

        $c4 = new Category();
        $c4->setParent($mainCategory3);
        $c4->setName('PS4');

        $c5 = new Category();
        $c5->setParent($mainCategory3);
        $c5->setName('Xbox 360');

        $c6 = new Category();
        $c6->setParent($mainCategory3);
        $c6->setName('3DS');

        $mainCategory4 = new Category();
        $mainCategory4->setName('食品');
        $mainCategory4->setPriority(1);

        $c7 = new Category();
        $c7->setParent($mainCategory4);
        $c7->setName('澳洲大龙虾');


        $manager->persist($mainCategory1);
        $manager->persist($c1);
        $manager->persist($c2);

        $manager->persist($mainCategory2);
        $manager->persist($c3);

        $manager->persist($mainCategory3);
        $manager->persist($c4);
        $manager->persist($c5);
        $manager->persist($c6);
        $manager->persist($mainCategory4);
        $manager->persist($c7);

        $manager->persist($product);

        $manager->flush();

    }
}