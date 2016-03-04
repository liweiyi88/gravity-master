<?php
/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 29/02/2016
 * Time: 5:43 PM
 */

namespace AppBundle\Controller\Admin;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProductController extends Controller
{
    /**
     * @Route("/admin/product/list", name="admin_product_list")
     */
    public function listAction(Request $request)
    {
        $products = $this->getDoctrine()->getRepository('AppBundle:Product')->findAllWithCategoryBrand();

        $product = new Product();
        $form = $this->createFormBuilder($product)
            ->add('name',TextType::class,array('label'=>'产品名称'))
            ->add('brand', EntityType::class,array(
                'class' => 'AppBundle\Entity\Brand',
                'query_builder' => function (EntityRepository $br) {
                    return $br->createQueryBuilder('b');
                },
                'choice_label' => 'name',
                'required' => true,
                'label' => '添加品牌'
            ))
            ->add('price',MoneyType::class, array(
                'label' => '产品价格',
                'currency' => ''
            ))
            ->add('categories', CollectionType::class, array(
                  'entry_type' => EntityType::class,
                  'entry_options' => array(
                      'class' =>'AppBundle:Category',
                      'query_builder' => function (EntityRepository $er) {
                          return $er->createQueryBuilder('c')
                              ->where('c.parent IS NOT NULL');
                      },
                      'choice_label' => 'name',
                      'label' => false,
                      'attr'      => array('class' => 'form-control'),
                      'required' => false,
                      'placeholder'=>'请选择分类'
                  ),
                  'by_reference' => false,
                  'allow_add' => true,
                  'allow_delete' => true,
                  'label'=>false
              ))

            ->add('save',SubmitType::class, array('label'=>'确认产品'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash(
                'notice',
                '添加成功!'
            );

            return $this->redirectToRoute('admin_product_list');
        }



        return $this->render('admin/product_list.html.twig',array('products'=>$products, 'form'=>$form->createView()));
    }


    /**
     * @Route("/admin/product/edit/{id}", name="admin_product_edit")
     */
    public function editAction(Request $request, $id)
    {
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->findById($id);

        $form = $this->createFormBuilder($product)
            ->add('name',TextType::class,array('label'=>'产品名称'))
            ->add('brand', EntityType::class,array(
                'class' => 'AppBundle\Entity\Brand',
                'query_builder' => function (EntityRepository $br) {
                    return $br->createQueryBuilder('b');
                },
                'choice_label' => 'name',
                'required' => true,
                'label' => '添加品牌'
            ))
            ->add('price',MoneyType::class, array(
                'label' => '产品价格',
                'currency' => ''
            ))
            ->add('categories', CollectionType::class, array(
                'entry_type' => EntityType::class,
                'entry_options' => array(
                    'class' =>'AppBundle:Category',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->where('c.parent IS NOT NULL');
                    },
                    'choice_label' => 'name',
                    'label' => false,
                    'attr'      => array('class' => 'form-control'),
                    'required' => false,
                    'placeholder'=>'请选择分类'
                ),
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'label'=>false
            ))

            ->add('save',SubmitType::class, array('label'=>'确认产品'))
            ->getForm();

        $form->handleRequest($request);


        if($form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            $this->addFlash(
                'notice',
                '添加成功!'
            );

            return $this->redirectToRoute('admin_product_edit',array('id'=>$id));
        }

        return $this->render('admin/product_edit.html.twig',array('product'=>$product, 'form'=>$form->createView()));

    }

}