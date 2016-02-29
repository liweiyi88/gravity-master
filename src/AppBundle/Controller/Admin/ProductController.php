<?php
/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 29/02/2016
 * Time: 5:43 PM
 */

namespace AppBundle\Controller\Admin;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class ProductController extends Controller
{
    /**
     * @Route("/admin/product/list", name="admin_product_list")
     */
    public function listAction(Request $request)
    {

        $products = $this->getDoctrine()->getRepository('AppBundle:Product')->findAll();


        return $this->render('admin/product_list.html.twig',array('products'=>$products));
    }

}