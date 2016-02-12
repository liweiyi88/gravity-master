<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Brand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class BrandController extends Controller
{
    /**
     * @Route("/admin/brand-list", name="admin_brand_list")
     */
    public function newAction(Request $request)
    {
        $brand = new Brand();

        $form = $this->createFormBuilder($brand)
            ->add('name',TextType::class,array('label'=>'品牌名称'))
            ->add('description',TextType::class,array('label'=>'品牌介绍','required'=>false))
            ->add('website',TextType::class,array('label'=>'品牌网页','required'=>false))
            ->add('file',FileType::class,array('label'=>'品牌logo'))
            ->add('save',SubmitType::class, array('label'=>'确认品牌'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $brand->upload();

            $em->persist($brand);
            $em->flush();

            $this->addFlash(
                'notice',
                '添加成功!'
            );

            return $this->redirectToRoute('admin_brand_list');
        }


        $brands = $this->getDoctrine()->getRepository('AppBundle:Brand')->findAll();


        return $this->render('admin/brand_list.html.twig',array('form'=>$form->createView() ,'brands' => $brands));
    }


    /**
     * @Route("/admin/brand-edit/{id}", name="admin_brand_edit")
     */
    public function editAction(Request $request,$id)
    {
        $brand = $this->getDoctrine()->getRepository('AppBundle:Brand')->findById($id);

        $form = $this->createFormBuilder($brand)
            ->add('name',TextType::class,array('label'=>'品牌名称'))
            ->add('description',TextType::class,array('label'=>'品牌介绍','required'=>false))
            ->add('website',TextType::class,array('label'=>'品牌网页','required'=>false))
            ->add('file',FileType::class,array('label'=>'品牌logo','required'=>false))
            ->add('save',SubmitType::class, array('label'=>'确认修改'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $brand->upload();

            $em->persist($brand);
            $em->flush();

            $this->addFlash(
                'notice',
                '修改成功!'
            );

            return $this->redirectToRoute('admin_brand_edit',array('id'=>6));
        }

        return $this->render('admin/brand_edit.html.twig',array('form'=>$form->createView(),'brand'=>$brand));

    }
}
