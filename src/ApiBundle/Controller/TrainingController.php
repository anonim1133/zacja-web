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

			//'_id, id, score, gpx, training_type, time, time_active, moves, speed_max, speed_avg, tempo_min, tempo_avg,
		    // distance, altitude_min, altitude_max, altitude_upward, altitude_downward, gpx_file, '
		    $t->setUserId($user->getId());
		    $t->setScore($training['score']);
		    $t->setDate($date);
		    $t->setType($training['training_type']);
		    $t->setTime($training['time']);
		    $t->setTimeActive($training['time_active']);

		    if(isset($training['moves'])) $t->setMoves($training['moves']);
		    else $t->setMoves(0);

		    $t->setSpeedMax($training['speed_max']);
		    $t->setSpeedAvg($training['speed_avg']);
		    $t->setTempoMin($training['tempo_min']);
		    $t->setTempoAvg($training['tempo_avg']);
		    $t->setDistance($training['distance']);
		    $t->setAltitudeMin($training['altitude_min']);
		    $t->setAltitudeMax($training['altitude_max']);
		    $t->setAltitudeUpward($training['altitude_upward']);
		    $t->setAltitudeDownward($training['altitude_downward']);
		    $t->setGpx($training['gpx_file']);

		    $em->persist($t);
		    $em->flush();

		    if($em->contains($t))
			    $response->setContent("Success");
		    else
			    $response->setContent("Failure");
	    }else{
		    $response->setContent("Invalid userkey");
	    }


	    return $response;
    }

}
