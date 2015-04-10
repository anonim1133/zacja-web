<?php

namespace ZacjaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class indexController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction(){
	    $em = $this->getDoctrine()->getManager();

	    $trainings = $em->getRepository('ZacjaBundle:Training')->getLast();
	    $conquers = $em->getRepository('ZacjaBundle:Conquer')->getLast();

	    if ($this->get('security.context')->isGranted('ROLE_USER')) {// Logged in with user class
		    $user = $this->get('security.token_storage')->getToken()->getUser();

		    return $this->render(
			    'ZacjaBundle:index:index.html.twig',
			    array('username' => $user,
				    'signedIn' => true,
				    'trainings' => $trainings,
				    'conquers' => $conquers
			    )
		    );
	    }else{//not logged in, or logged with other class than user
		    return $this->render(


			    'ZacjaBundle:index:index.html.twig',
			    array('username' => 'stranger',
				    'signedIn' => false,
				    'trainings' => $trainings,
				    'conquers' => $conquers
			    )
		    );
	    }
    }
}

