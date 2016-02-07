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
     * @Route("/admin/brand/new", name="admin_brand_new")
     */
    public function newAction(Request $request)
    {
        $brand = new Brand();

        $form = $this->createFormBuilder($brand)
            ->add('name',TextType::class,array('label'=>'品牌名称'))
            ->add('description',TextType::class,array('label'=>'品牌介绍'))
            ->add('file',FileType::class,array('label'=>'品牌logo'))
            ->add('save',SubmitType::class, array('label'=>'确认品牌'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $brand->upload();

            $em->persist($brand);
            $em->flush();

            return $this->redirectToRoute('admin_brand_new');
        }



        return $this->render('admin/brand_new.html.twig',array('form'=>$form->createView()));
    }
}
