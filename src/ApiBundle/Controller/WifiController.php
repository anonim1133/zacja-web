<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


use ZacjaBundle\Entity\Wifi;

class WifiController extends Controller
{
    /**
     * @Route("/api/addWifi")
     * @Template()
     */
    public function AddWifiAction()
    {
	    $em = $this->getDoctrine()->getManager();

	    $response = new Response();
	    $response->headers->set('Content-Type', 'text/html');

	    $request = Request::createFromGlobals();
	    $key = $request->request->get('key');//"39d275276fab1ed9491f700f3aefbce2";
	    $wifi = json_decode($request->request->get('wifi'), 1);

	    $user = $em->getRepository('ApiBundle:ApiKeys')->findOneBy(array('apikey' => $key));

	    if($user != null){
		    $new_wifi = new Wifi();

		    $new_wifi->setUserId($user->getId());
		    $new_wifi->setSsid($wifi['ssid']);
		    $new_wifi->setBssid($wifi['bssid']);
		    $new_wifi->setSignal($wifi['signal']);
		    $new_wifi->setSecurity($wifi['security']);
		    $new_wifi->setLongitude($wifi['lon']);
		    $new_wifi->setLatitude($wifi['lat']);

		    $em->persist($new_wifi);
		    $em->flush();

		    if($em->contains($new_wifi))
			    $response->setContent("Success");
		    else
			    $response->setContent("Failure");

	    }

		return $response;
    }

}
