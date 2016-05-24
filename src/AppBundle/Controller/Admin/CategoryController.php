<?php
/**
 * Created by PhpStorm.
 * User: Julian
 * Date: 27/02/2016
 * Time: 2:39 PM
 */

namespace AppBundle\Controller\Admin;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;


class CategoryController extends Controller
{

    /**
     * @Route("/admin/category/list", name="admin_category_list")
     */
    public function listAction(Request $request)
    {
        $category = new Category();

        $form = $this->createFormBuilder($category)
            ->add('name',TextType::class,array('label'=>'种类名称'))
            ->add('parent', EntityType::class,array(
                'class' => 'AppBundle\Entity\Category',
                'query_builder' => function (EntityRepository $cr) {
                    return $cr->createQueryBuilder('c')->where('c.parent is null');
                },
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => '无父类',
                'label' => '添加父类',
            ))
            ->add('save',SubmitType::class, array('label'=>'确认种类'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($category);
            $em->flush();


            $this->addFlash(
                'notice',
                '添加成功!'
            );
            return $this->redirectToRoute('admin_category_list');

        }

        $query = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        $paginator  = $this->get('knp_paginator');
        $categories = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5 /*limit per page*/
        );

        return $this->render('admin/category_list.html.twig',array('form'=>$form->createView(),'categories'=>$categories));
    }

    /**
     * @Route("/admin/category/edit/{id}", name="admin_category_edit")
     */
    public function editAction(Request $request,$id)
    {
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->findById($id);

        $form = $this->createFormBuilder($category)
            ->add('name',TextType::class,array('label'=>'种类名称'))
            ->add('parent', EntityType::class,array(
                'class' => 'AppBundle\Entity\Category',
                'query_builder' => function (EntityRepository $cr) {
                    return $cr->createQueryBuilder('c')->where('c.parent is null');
                },
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => '无父类',
                'label' => '添加父类'
            ))
            ->add('save',SubmitType::class, array('label'=>'确认种类'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($category);
            $em->flush();

            $this->addFlash(
                'notice',
                '修改成功!'
            );

            return $this->redirectToRoute('admin_category_list');
        }

        return $this->render('admin/category_edit.html.twig',array('form'=>$form->createView(),'category'=>$category));

    }

}