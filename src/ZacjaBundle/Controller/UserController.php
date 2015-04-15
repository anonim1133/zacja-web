<?php

namespace ZacjaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Profiler\Profile;

class UserController extends Controller
{
    /**
     * @Route("/user/trainings/{user}")
     * @Template()
     */
    public function showUserTrainingsAction($user){
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
    public function showProfileAction($user){

	    $canEdit = false;

	    if ($this->get('security.context')->isGranted('ROLE_USER')){//signed in
		    $username = $this->get('security.token_storage')->getToken()->getUser();

		    if($username == $user){//signed as user which profile is shown
			    $canEdit = true;
		    }
	    }

	    $user = $this->getDoctrine()->getRepository("ZacjaBundle:User")->findOneByUsername($user);

		  return $this->render(
		    'ZacjaBundle:User:showProfile.html.twig', array(
			  'user' => $user,
			  'canEdit' => $canEdit
		  ));
    }

	/**
	 * @Route("/user/editprofile/"))
	 * @Method("GET")
	 */
	public function editProfileAction(){
		if ($this->get('security.context')->isGranted('ROLE_USER')){//signed in
			$username = $this->get('security.token_storage')->getToken()->getUser();
			$profile = $this->getDoctrine()->getRepository("ZacjaBundle:User")->findOneBy(array("username" => $username))->getProfile();

			$form = $this->createFormBuilder($profile)
				->add('name')
				->add('pseudonym')
				->add('surname')
				->add('avatar')
				->add('about')
				->add('save', 'submit', array('label' => 'Edit profile'))
				->getForm();

			return $this->render('@Zacja/User/editProfile.html.twig', array(
				'form' => $form->createView(),
			));
			return $this->render(
				'ZacjaBundle:User:editProfile.html.twig', array());
		}else{
			return $this->redirectToRoute('index');
		}
	}

	/**
	 * @Route("/user/editprofile/"))
	 * @Method("POST")
	 */
	public function saveProfileAction(){
		$request = $this->getRequest();

		$username = $this->get('security.token_storage')->getToken()->getUser();
		$profile = $this->getDoctrine()->getRepository("ZacjaBundle:User")->findOneBy(array("username" => $username))->getProfile();

		$form = $this->createFormBuilder($profile)
			->add('name')
			->add('pseudonym')
			->add('surname')
			->add('avatar')
			->add('about')
			->add('save', 'submit', array('label' => 'Edit profile'))
			->getForm();

		$form->handleRequest($request);

		if ($form->isValid()){
			$em = $this->getDoctrine()->getManager();

			$em->persist($profile);
			$em->flush();

			return $this->redirectToRoute('index');
		}else{
			return $this->redirectToRoute('zacja_user_editprofile');
		}
	}

    /**
     * @Route("/user/trainings/{user}/{type}")
     * @Template()
     */
    public function showUserTrainingsByTypeAction($user, $type){
	    $trainings = $this->getDoctrine()->getRepository("ZacjaBundle:Training")->findByUsernameType($user, $type);
	    //dump($trainings);

	    return $this->render(
		    'ZacjaBundle:User:showUserTrainingsByType.html.twig',
		    array('trainings' => $trainings)
	    );
    }

}
