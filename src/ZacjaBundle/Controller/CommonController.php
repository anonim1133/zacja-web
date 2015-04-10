<?php

namespace ZacjaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CommonController extends Controller{

    /**
     * @Route("/header")
     * @Template()
     */
    public function headerAction(){

	    if ($this->get('security.context')->isGranted('ROLE_USER')){
		    $user = $this->get('security.token_storage')->getToken()->getUser();

		    $username = $user->getUserName();
		    $signedin = true;
	    }else{
		    $username = 'stranger';
		    $signedin = false;
	    }


	    return $this->render(
		    'ZacjaBundle:Common:header.html.twig',
		    array(
			    'username' => $username,
			    'signedIn' => $signedin
		    )
	    );
    }

    /**
     * @Route("/footer")
     * @Template()
     */
    public function footerAction()
    {
        return array(
                // ...
            );    }

}
