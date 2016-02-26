<?php
/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 24/02/2016
 * Time: 4:53 PM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class BrandController extends Controller
{

    /**
     * @Route("/brand/detail/{id}", name="brand_detail")
     */
    public function detailAction($id)
    {
        $brand = $this->getDoctrine()->getRepository('AppBundle:Brand')->findById($id);
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


        return $this->render('brand/brand_detail.html.twig',
            array('settings'=>$homepageSettings,
                'brand' => $brand,
                'categories' => $categories,
                'brands' => $brands
            )
        );
    }

}