<?php
/**
 * Created by PhpStorm.
 * User: emilychen
 * Date: 18/01/2016
 * Time: 8:17 PM
 */

namespace AppBundle\Controller\Admin;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * @Route("/admin/", name="admin_home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('admin/index.html.twig');
    }


    /**
     * @Route("/admin/settings/{name}", name="admin_settings_company")
     */
    public function settingsAction($name)
    {
        if($name=='company')
        {
            return $this->render('admin/settings_company.html.twig');
        }

    }

}