<?php

namespace ZacjaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class UserController extends Controller
{
    /**
     * @Route("/user/trainings/{user}")
     * @Template()
     */
    public function showUserTrainingsAction($user)
    {
	    $trainings = $this->getDoctrine()->getRepository("ZacjaBundle:Training")->findByUserName($user);
	    //dump($trainings);

	    return $this->render(
		    'ZacjaBundle:User:showUserTrainings.html.twig',
		    array('trainings' => $trainings)
	    );
    }

    /**
     * @Route("/user/conquers/{user}")
     * @Template()
     */
    public function showUserConquersAction($user){
	    $conquers = $this->getDoctrine()->getRepository("ZacjaBundle:Conquer")->findByUserName($user);
		//dump($conquers);

	    return $this->render(
		    'ZacjaBundle:User:showUserConquers.html.twig',
		    array('conquers' => $conquers)
	    );
    }

    /**
     * @Route("/user/{user}")
     * @Template()
     */
    public function showProfileAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/user/trainings/{user}/{type}")
     * @Template()
     */
    public function showUserTrainingsByTypeAction($user, $type)
    {
        return array(
                // ...
            );    }

}
