<?php

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TrainingController extends Controller
{
    /**
     * @Route("/api/addTraining")
     * @Template()
     */
    public function AddTrainingAction()
    {
        return array(
                // ...
            );    }

}
