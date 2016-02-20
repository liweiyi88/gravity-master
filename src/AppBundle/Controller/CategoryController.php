<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CategoryController extends Controller
{

    /**
     * @Route("/category-list/{id}", name="category_list")
     */
    public function listAction($id)
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();
        $brands = $this->getDoctrine()->getRepository('AppBundle:Brand')->findAll();
        $homepageSettings = $this->getDoctrine()->getRepository('AppBundle:HomepageSettings')->findSettings();
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->findById($id);

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

        return $this->render('category/category_list.html.twig',
                    array('settings'=>$homepageSettings,
                           'category' => $category,
                           'categories' => $categories,
                           'brands' => $brands
                         )
                     );
    }
}
