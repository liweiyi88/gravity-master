<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CategoryController extends Controller
{

    /**
     * @Route("/category/list/{id}", name="category_list")
     */
    public function listAction($id)
    {
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->findById($id);

        return $this->render('category/category_list.html.twig',
                    array(
                           'category' => $category
                         )
                     );
    }
}
