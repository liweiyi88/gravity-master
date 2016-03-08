<?php
/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 18/01/2016
 * Time: 8:14 PM
 */

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {

        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        $brands = $this->getDoctrine()->getRepository('AppBundle:Brand')->findAll();
        $homepageSettings = $this->getDoctrine()->getRepository('AppBundle:HomepageSettings')->findSettings();


        foreach($categories as $category)
        {
            if($category->getParent() == null)
            {
                $categoryBrands = array();
                foreach($category->getChildren() as $child)
                {
                    foreach($child->getProducts() as $product)
                    {
                        foreach($brands as $brand)
                        {
                            if($brand->getName() == $product->getBrand()->getName())
                            {
                                $isAdd = true;
                                foreach($categoryBrands as $categoryBrand)
                                {
                                    if($categoryBrand->getName() == $brand->getName())
                                    {
                                        $isAdd = false;
                                    }
                                }
                                if($isAdd)
                                {
                                    $categoryBrands[] = $brand;
                                }
                            }
                        }
                    }
                }
                $category->setBrands($categoryBrands);
            }
        }

        // replace this example code with whatever you need
        return $this->render('product/index.html.twig',array(
                                                     'categories' => $categories,
                                                     'brands' => $brands,
                                                     'settings' => $homepageSettings
        ));
    }


    /**
     * @Route("/product/detail/{id}", name="product_detail")
     */
    public function detailAction($id)
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        $brands = $this->getDoctrine()->getRepository('AppBundle:Brand')->findAll();
        $homepageSettings = $this->getDoctrine()->getRepository('AppBundle:HomepageSettings')->findSettings();

        foreach($categories as $eachCategory)
        {
            if($eachCategory->getParent() == null)
            {
                $categoryBrands = array();
                foreach($eachCategory->getChildren() as $child)
                {
                    foreach($child->getProducts() as $product)
                    {
                        foreach($brands as $brand)
                        {
                            if($brand->getName() == $product->getBrand()->getName())
                            {
                                $isAdd = true;
                                foreach($categoryBrands as $categoryBrand)
                                {
                                    if($categoryBrand->getName() == $brand->getName())
                                    {
                                        $isAdd = false;
                                    }
                                }
                                if($isAdd)
                                {
                                    $categoryBrands[] = $brand;
                                }
                            }
                        }
                    }
                }
                $eachCategory->setBrands($categoryBrands);
            }
        }

        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->findById($id);
        $subCategoryArr = array();

        if($product->getCategories() != null)
        {
            foreach($product->getCategories() as $category )
            {
                if($category->getParent() != null)
                {
                    foreach($category->getParent()->getChildren() as $c )
                    {
                        $isAdd = true;
                        foreach($subCategoryArr as $s)
                        {
                            if($s->getId() == $c->getId())
                            {
                                $isAdd = false;
                            }
                        }
                        if($isAdd)
                        {
                            $subCategoryArr[] = $c;
                        }
                    }
                }
            }
        }

        return $this->render('product/product_detail.html.twig',array(
            'categories' => $categories,
            'brands' => $brands,
            'settings' => $homepageSettings,
            'product' => $product,
            'subCategories' => $subCategoryArr
        ));


    }



    /**
     * @Route("/product/ajax/get", name="ajax_get_product")
     */
    public function ajaxGetProduct(Request $request)
    {

        $json = '';
        $productName = trim($request->request->get('productName'));

        $products = $this->getDoctrine()->getRepository('AppBundle:Product')->findByName($productName);

        if($products != null)
        {
            foreach($products as $product)
            {
                $productArray['id'] = $product->getId();
                $productArray['name'] = $product->getName();
                $productArray['price'] = $product->getPrice();
                $productArray['description'] = $product->getDescription();
                $json[] = $productArray;
            }
        }

        // replace this example code with whatever you need
        return new JsonResponse($json);
    }


}