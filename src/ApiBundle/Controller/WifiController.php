<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class WifiController extends Controller
{
    /**
     * @Route("/api/addWifi")
     * @Template()
     */
    public function AddWifiAction()
    {
        return array(
                // ...
            );    }

}
