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

		    return $this->render('ZacjaBundle:index:index.html.twig',
			    array('trainings' => $trainings,
				    'conquers' => $conquers
			    )
		    );
    }
}

