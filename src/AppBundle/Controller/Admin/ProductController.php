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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductController extends Controller
{
    /**
     * @Route("/admin/product/list/{page}", name="admin_product_list")
     */
    public function listAction(Request $request, $page = 1)
    {
        $products = $this->getDoctrine()->getRepository('AppBundle:Product')->findAllWithCategoryBrand($page);

        // You can also call the count methods (check PHPDoc for `paginate()`)
        $totalProductsReturned = $products->getIterator()->count(); # Total fetched (ie: `5` posts)
        $totalProducts = $products->count(); # Count of ALL posts (ie: `20` posts)
        $iterator = $products->getIterator(); # ArrayIterator

        // ... get posts from DB...
        $limit = 5;
        $maxPages = ceil($totalProducts / $limit);
        $thisPage = $page;
        // ... render view pass through the 3 above variables to calculate pages
        // return $this->render('view.twig.html', compact('categories', 'maxPages', 'thisPage'));

        $product = new Product();
        $product->setIsShownNav(true);
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
            ->add('description',TextareaType::class,array(
                'attr' => array('class' => 'form-control'),
                'required' => false,
                'label' => '产品介绍'
            ))
            ->add('isShownNav',CheckboxType::class,array(
                'label' => '是否显示在主页导航栏',
                'required' => false
            ))
            ->add('file',FileType::class,array('label'=>'产品图片','required'=>false))
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


        return $this->render('admin/product_list.html.twig',array('products'=>$products,
            'maxPages'=>$maxPages, 'thisPage'=>$thisPage, 'form'=>$form->createView()));
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
            ->add('description',TextareaType::class,array(
                'attr' => array('class' => 'form-control'),
                'required' => false,
                'label' => '产品介绍'
            ))
            ->add('isShownNav',CheckboxType::class,array(
                'label' => '是否显示在主页导航栏',
                'required' => false
            ))
            ->add('file',FileType::class,array('label'=>'产品图片','required'=>false))
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
                '修改成功!'
            );

            return $this->redirectToRoute('admin_product_list');
        }

        return $this->render('admin/product_edit.html.twig',array('product'=>$product, 'form'=>$form->createView()));

    }

}