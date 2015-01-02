<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AuthController extends Controller
{
    /**
     * @Route("/api/SignIn")
     * @Template()
     */
    public function SignInAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/api/SignUp")
     * @Template()
     */
    public function signUpAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/api/LoginCheck")
     * @Template()
     */
    public function CheckAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/api/Confirm")
     * @Template()
     */
    public function ConfirmAction()
    {
        return array(
                // ...
            );    }

}
