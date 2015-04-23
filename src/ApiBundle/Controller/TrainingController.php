<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use ZacjaBundle\Entity\Training;


class TrainingController extends Controller
{
    /**
     * @Route("/api/addTraining")
     * @Template()
     */
    public function AddTrainingAction(){
	    $response = new Response();
	    $response->headers->set('Content-Type', 'text/html');

	    $request = Request::createFromGlobals();
	    $key = $request->request->get('key');//"39d275276fab1ed9491f700f3aefbce2";
	    $training = json_decode($request->request->get('training'), 1);
	    $date = new \DateTime(str_replace(".gpx", "", $training['gpx']));

	    $em = $this->getDoctrine()->getManager();
	    $user = $em->getRepository('ApiBundle:ApiKeys')->findOneBy(array('apikey' => $key));

	    if($user != null){
			//write training to db
			$t = new Training();

			$user = $em->getRepository('ZacjaBundle:User')->findOneById($user->getUserId());

		    $t->setUserId($user->getId());
		    $t->setUser($user);
		    $t->setScore($training['score']);
		    $t->setDate($date);
		    $t->setType($training['training_type']);
		    $t->setTime($training['time']);
		    $t->setTimeActive($training['time_active']);

		    if(isset($training['moves'])) $t->setMoves($training['moves']);
		    else $t->setMoves(0);

		    if(isset($training['speed_max']))
		        $t->setSpeedMax($training['speed_max']);
		    if(isset($training['speed_avg']))
		        $t->setSpeedAvg($training['speed_avg']);
		    if(isset($training['tempo_min']))
		        $t->setTempoMin($training['tempo_min']);
		    if(isset($training['tempo_avg']))
		        $t->setTempoAvg($training['tempo_avg']);
		    $t->setDistance($training['distance']);
		    $t->setAltitudeMin($training['altitude_min']);
		    $t->setAltitudeMax($training['altitude_max']);
		    $t->setAltitudeUpward($training['altitude_upward']);
		    $t->setAltitudeDownward($training['altitude_downward']);
		    $t->setGpx($training['gpx_file']);

		    $em->persist($t);
		    $em->flush();

		    if($em->contains($t)){
			    $response->setContent("Success");

			    if($t->getType() == 'Walking'){
				    $date = new DateTime();
				    if($this->getDoctrine()->getRepository("ZacjaBundle:Training")->getStepsByDay($user->getId(), $t->getDate()->format('Y-m-d')) >= 10000){
					    $this->get('badge')->add($user->getId(), 4);
				    }

				    if($this->getDoctrine()->getRepository("ZacjaBundle:Training")->getTotalDistance($user->getId, $t->getType()) >= 32){
					    $this->get('badge')->add($user->getId(), 5);
				    }

			    }elseif($t->getType() == 'Biking'){
				    if($this->getDoctrine()->getRepository("ZacjaBundle:Training")->getTotalDistance($user->getId, $t->getType()) >= 1024){
					    $this->get('badge')->add($user->getId(), 2);
				    }
			    }elseif($t->getType() == 'Running'){
				    if($this->getDoctrine()->getRepository("ZacjaBundle:Training")->getTotalDistance($user->getId, $t->getType()) >= 256){
					    $this->get('badge')->add($user->getId(), 3);
				    }
			    }

		    }else{
			    $response->setContent("Failure");
		    }
	    }else{
		    $response->setContent("Invalid userkey");
	    }


	    return $response;
    }

}
