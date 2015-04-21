<?php

namespace ZacjaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Profiler\Profile;

class UserController extends Controller{

	/**
	 * @Route("/user/{user}")
	 * @Template()
	 */
	public function showProfileAction($user){

		$canEdit = false;
		$signedIn = false;
		$areFriends = false;

		if ($this->get('security.context')->isGranted('ROLE_USER')){//signed in
			$signedIn = true;
			$username = $this->get('security.token_storage')->getToken()->getUser();

			// Check if they are friends
			if($this->getDoctrine()->getRepository("ZacjaBundle:User")->areFriends($username, $user))
				$areFriends = true;

			if($username == $user){//signed as user which profile is shown
				$canEdit = true;
			}
		}

		$user = $this->getDoctrine()->getRepository("ZacjaBundle:User")->findOneByUsername($user);

		return $this->render(
			'ZacjaBundle:User:showProfile.html.twig', array(
			'user' => $user,
			'areFriends' => $areFriends,
			'signedIn' => $signedIn,
			'canEdit' => $canEdit
		));
	}

    /**
     * @Route("/user/trainings/{user}")
     * @Template()
     */
    public function showUserTrainingsAction($user){

	    return $this->render(
		    'ZacjaBundle:User:showUserTrainings.html.twig',
		    array('user' => $user)
	    );
    }

	public function getUserTrainingsAction($user, $limit = null){
		$trainings = $this->getDoctrine()->getRepository("ZacjaBundle:Training")->findByUserName($user, $limit);

		return $this->render(
			'ZacjaBundle:User:getUserTrainings.html.twig',
			array('trainings' => $trainings)
		);

	}

    /**
     * @Route("/user/conquers/{user}")
     * @Template()
     */
    public function showUserConquersAction($user){
	    return $this->render(
		    'ZacjaBundle:User:showUserConquers.html.twig',
		    array('user' => $user)
	    );
    }

	public function getUserConquersAction($user, $limit = null){
		$conquers = $this->getDoctrine()->getRepository("ZacjaBundle:Conquer")->findByUserName($user, $limit);

		return $this->render(
			'ZacjaBundle:User:getUserConquers.html.twig',
			array('conquers' => $conquers)
		);
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
		if ($this->get('security.context')->isGranted('ROLE_USER')){//signed in
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

			if($form->isValid()){
				$em = $this->getDoctrine()->getManager();

				$em->persist($profile);
				$em->flush();

				return $this->redirectToRoute('index');
			}else{
				return $this->redirectToRoute('zacja_user_editprofile');
			}
		}else{
			return $this->redirectToRoute('index');
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

	/**
	 * @Route("/ForeverAlone/", name="foreverAlone")
	 */
	public function feelsAction(){
		return $this->render("ZacjaBundle:Common:foreveralone.html.twig");
	}

	/**
	 * @Route("/user/addFriend/{friend}", name="addFriend")
	 */
	public function addFriendAction($friend){
		if ($this->get('security.context')->isGranted('ROLE_USER')){//signed in
			$username = $this->get('security.token_storage')->getToken()->getUser();

			if($username == $friend){//trying to become friends with himself
				return $this->redirectToRoute('foreverAlone');
			}

			//Check if they are friends already. If they are, redirect to profile page
			if($this->getDoctrine()->getRepository("ZacjaBundle:User")->areFriends($username, $friend))
				return $this->redirectToRoute('zacja_user_showprofile', array('user' => $friend));

			//Make them friends!
			$user = $this->getDoctrine()->getRepository("ZacjaBundle:User")->findOneByUsername($username);
			$friend = $this->getDoctrine()->getRepository("ZacjaBundle:User")->findOneByUsername($friend);

			$user->getFriends()->add($friend);

			$this->getDoctrine()->getEntityManager()->flush();
		}

		return $this->redirectToRoute('zacja_user_showprofile', array('user' => $friend->getUserName()));
	}

}
