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

        return $this->render('brand/brand_detail.html.twig',
            array(
                'brand' => $brand,
            )
        );
    }

}