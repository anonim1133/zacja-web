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

	    $signed_in = false;
	    $friends_trainings = null;

	    $trainings = $em->getRepository('ZacjaBundle:Training')->getLast();
	    $conquers = $em->getRepository('ZacjaBundle:Conquer')->getLast();

	    if ($this->get('security.context')->isGranted('ROLE_USER')){
		    $signed_in = true;
		    $username = $this->get('security.token_storage')->getToken()->getUser();
		    $friends_trainings = $em->getRepository('ZacjaBundle:Training')->findFriendsTrainings($username);
	    }


		    return $this->render('ZacjaBundle:index:index.html.twig',
			    array('friends_trainings' => $friends_trainings,
				    'trainings' => $trainings,
				    'conquers' => $conquers,
				    'signed_in' => $signed_in
			    )
		    );
    }
}

