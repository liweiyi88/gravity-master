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


        // replace this example code with whatever you need
        return $this->render('product/index.html.twig',array('categories'=>$categories));
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