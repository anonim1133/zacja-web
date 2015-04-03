<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use ZacjaBundle\Entity\Conquer;

class ConquerController extends Controller
{
    /**
     * @Route("/api/addConquer")
     * @Template()
     */
    public function AddConquerAction(){
	    $em = $this->getDoctrine()->getManager();

	    $response = new Response();
	    $response->headers->set('Content-Type', 'text/html');

	    $request = Request::createFromGlobals();
	    $key = $request->request->get('key');//"39d275276fab1ed9491f700f3aefbce2";
	    $conquer = json_decode($request->request->get('conquer'), 1);
	    $date = new \DateTime($conquer['date']);

	    $user = $em->getRepository('ApiBundle:ApiKeys')->findOneBy(array('apikey' => $key));

	    if($user != null){
			$new_conquer =  new Conquer();

		    $new_conquer->setUserId($user->getId());
		    $new_conquer->setDate($date);
		    $new_conquer->setScore($conquer['score']);
		    $new_conquer->setLongitude($conquer['lon']);
		    $new_conquer->setLatitude($conquer['lat']);


		    $old_conquer = $em->getRepository('ZacjaBundle:Conquer')->findOneBy(array(
			    'userId' => $user->getId(),
			    'date' => $date,
			    'score' => $conquer['score'],
			    'longitude' => $conquer['lon'],
			    'latitude' => $conquer['lat']));

		    if($old_conquer != null)
			    echo "Duplicate";
		    else{
			    $em->persist($new_conquer);
			    $em->flush();

			    if($em->contains($new_conquer))
				    $response->setContent("Success");
			    else
				    $response->setContent("Failure");
		    }
	    }

	    return $response;
    }

}
