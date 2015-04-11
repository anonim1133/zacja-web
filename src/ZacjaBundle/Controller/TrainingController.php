<?php

namespace ZacjaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TrainingController extends Controller
{
    /**
     * @Route("/training/{id}")
     * @Template()
     */
    public function showTrainingAction($id)
    {
	    $training = $this->getDoctrine()->getRepository("ZacjaBundle:Training")->findOneById("$id");

	    dump($training);

	    return $this->render(
		    'ZacjaBundle:Training:showTraining.html.twig',
		    array('training' => $training)
	    );
    }

}
