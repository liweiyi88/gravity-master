<?php
/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 18/01/2016
 * Time: 8:14 PM
 */

namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

}