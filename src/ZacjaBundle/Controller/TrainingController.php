<?php

namespace ZacjaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TrainingController extends Controller
{
    /**
     * @Route("/training/{id}", name="training")
     * @Template()
     */
    public function showTrainingAction($id){
	    $training = $this->getDoctrine()->getRepository("ZacjaBundle:Training")->findOneById("$id");

	    $can_edit = false;
	    if($this->get('security.context')->isGranted('ROLE_USER')){//signed in
		    $username = $this->get('security.token_storage')->getToken()->getUser();

		    if($username === $training->getUser()->getUserName())//signed in as user whoose training it is
			    $can_edit = true;
	    }

	    if($training->getType() === "Biking" || $training->getType() === "Running")
		    $pattern = '/<trkpt lat="([-+]?[0-9]*\.?[0-9]+)" lon="([-+]?[0-9]*\.?[0-9]+)">\s<ele>([-+]?[0-9]*\.?[0-9]+)<\/ele>\s<time>([0-9]{8}T[0-9]{6})<\/time>\s<speed>([-+]?[0-9]*\.?[0-9]+)<\/speed>\s<\/trkpt>/';
	    elseif($training->getType() === "Walking")
		    $pattern = '/<trkpt lat="([-+]?[0-9]*\.?[0-9]+)" lon="([-+]?[0-9]*\.?[0-9]+)">\s<ele>([-+]?[0-9]*\.?[0-9]+)<\/ele>\s<time>([0-9]{8}T[0-9]{6})<\/time>\s<speed>([-+]?[0-9]*\.?[0-9]+)<\/speed>\s<steps>([-+]?[0-9]*\.?[0-9]+)<\/steps>\s<\/trkpt>/';

	    if(isset($pattern)){
		    $gpx = preg_replace('/\s{2,8}/', ' ', $training->getGpx());
		    preg_match_all($pattern, $gpx, $gpx);

		    $training_data = [];
		    $count = count($gpx[1]);
		    for($i = 0; $i < $count; $i++){
			    $training_data[$i]['lat'] = $gpx[1][$i];
			    $training_data[$i]['lon'] = $gpx[2][$i];
			    $training_data[$i]['ele'] = $gpx[3][$i];
			    $training_data[$i]['time'] = strtotime($gpx[4][$i]);
			    $training_data[$i]['speed'] = round($gpx[5][$i], 2);
		    }

		    return $this->render(
			    'ZacjaBundle:Training:showTraining.html.twig',
			    array('training' => $training,
				    'gpx' => json_encode($training_data),
				    'can_edit' => $can_edit)
		    );
	    }else{
		    return $this->render(
			    'ZacjaBundle:Training:showTraining.html.twig',
			    array('training' => $training,
				    'avg' => ($training->getMoves() / $training->getDistance()),
				    'can_edit' => $can_edit)
		    );
	    }
    }

	/**
	 * @Route("/training/remove/{id}", name="training_remove")
	 */
	public function removeTrainingAction($id){
		if($this->get('security.context')->isGranted('ROLE_USER')){//signed in
			$training = $this->getDoctrine()->getRepository("ZacjaBundle:Training")->findOneById($id);
			$username = $this->get('security.token_storage')->getToken()->getUser();

			if($username === $training->getUser()->getUserName()){//signed in as user whoose training it is
				$em = $this->getDoctrine()->getEntityManager();

				$em->remove($training);
				$em->flush();
			}
		}

		return $this->redirectToRoute('index');
	}


	/**
	 * @Route("training/type/{type}", name="training_type")
	 * @Template()
	 */
	public function showTrainingByTypeAction($type){
		$trainings = $this->getDoctrine()->getRepository("ZacjaBundle:Training")->findByType($type);

		dump($trainings);

		return $this->render(
			'ZacjaBundle:Training:showTrainingsByType.html.twig',
			array('trainings' => $trainings)
		);
	}
}