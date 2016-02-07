<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\HomepageSettings;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class SettingsController extends Controller
{

    /**
     * @Route("/admin/settings/homepage", name="admin_settings_homepage")
     */
    public function homePageAction(Request $request)
    {
        $homepageSettings =  $this->getDoctrine()->getRepository('AppBundle:HomepageSettings')->findSettings();
        if($homepageSettings == null)
        {
            $homepageSettings = new HomepageSettings();
        }

        $form = $this->createFormBuilder($homepageSettings)
                ->add('tradingName',TextType::class,array('label'=>'公司名称'))
                ->add('mainHeading',TextType::class,array('label'=>'首页正中大标题'))
                ->add('subHeading',TextType::class,array('label'=>'首页正中副标题'))
                ->add('partnerHeading',TextType::class,array('label'=>'合作伙伴标题'))
                ->add('save',SubmitType::class, array('label'=>'确认设置'))
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            $em->persist($homepageSettings);
            $em->flush();

            $this->addFlash(
                'notice',
                '设置成功!'
            );

            return $this->redirectToRoute('admin_settings_homepage');
        }

        return $this->render('admin/settings_homepage.html.twig',array('form'=>$form->createView()));
    }
}
