<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function navigateAction()
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
                        foreach($brands as $eachBrand)
                        {
                            if($eachBrand->getName() == $product->getBrand()->getName())
                            {
                                $isAdd = true;
                                foreach($categoryBrands as $categoryBrand)
                                {
                                    if($categoryBrand->getName() == $eachBrand->getName())
                                    {
                                        $isAdd = false;
                                    }
                                }
                                if($isAdd)
                                {
                                    $categoryBrands[] = $eachBrand;
                                }
                            }
                        }
                    }
                }
                $eachCategory->setBrands($categoryBrands);
            }
        }


        return $this->render('navigation.html.twig', array(
            'categories' => $categories,
            'brands' => $brands,
            'settings' => $homepageSettings
        ));
    }
}
