<?php

/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 4/01/2016
 * Time: 10:42 PM
 */
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Brand;
use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Tests\B;

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





        $m1 = new Category();
        $m1->setName('奶粉');
        $m1->setPriority(1);

        $s1 = new Category();
        $s1->setName('婴儿奶粉');
        $s1->setParent($m1);

        $s2 = new Category();
        $s2->setName('成人奶粉');
        $s2->setParent($m1);

        $s3 = new Category();
        $s3->setName('成人羊奶');
        $s3->setParent($m1);

        $s4 = new Category();
        $s4->setName('婴儿羊奶');
        $s4->setParent($m1);

        $manager->persist($m1);
        $manager->persist($s1);
        $manager->persist($s2);
        $manager->persist($s3);
        $manager->persist($s4);


        $b1 = new Brand();
        $b1->setName('Ballamy');

        $b2 = new Brand();
        $b2->setName('A2');

        $b3 = new Brand();
        $b3->setName('S26');

        $b4 = new Brand();
        $b4->setName('Aptamil');

        $b5 = new Brand();
        $b5->setName('Heinz');

        $manager->persist($b1);
        $manager->persist($b2);
        $manager->persist($b3);
        $manager->persist($b4);
        $manager->persist($b5);


        $p1 = new Product();
        $p1->setName('Ballamy 有机奶粉三段');
        $p1->addCategory($s4);
        $p1->setBrand($b1);


        $p2 = new Product();
        $p2->setName('Ballamy 有机奶粉二段');
        $p2->addCategory($s4);
        $p2->setBrand($b1);

        $p3 = new Product();
        $p3->setName('Ballamy 有机奶粉一段');
        $p3->addCategory($s4);
        $p3->setBrand($b1);


        $manager->persist($p1);
        $manager->persist($p2);
        $manager->persist($p3);

        $manager->flush();

    }
}