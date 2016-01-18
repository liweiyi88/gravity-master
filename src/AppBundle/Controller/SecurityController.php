<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login_route")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }


    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {

    }


    /**
     * @Route("/forget-password", name="forget_password")
     */
    public function passwordResetAction(Request $request)
    {

        $user = new User();
        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Email reset code to me'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if($user->getEmail() != null)
            {
                $username = $user->getEmail();
            }
            else if($user->getUsername() != null)
            {
                $username = $user->getUsername();
            }

            $user = $this->getDoctrine()->getRepository('AppBundle:User')->findUserByUsernameOrEmail($username);
            if($user == null)
            {
               $this->addFlash('error','No user with this username exists');
            }
            else
            {

                $this->addFlash('notice','An email has been sent with instructions for resetting your password. If you do not receive it within an hour or two, check your spam folder.');
            }

            return $this->redirectToRoute('forget_password');
        }


        return $this->render('security/password_reset.html.twig',array('form'=>$form->createView()));
    }






}
