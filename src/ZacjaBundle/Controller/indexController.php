<?php

namespace ZacjaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class indexController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction(){
		$trainings = $this->getTrainings();
	    $conquers = $this->getConquers();

	    if ($this->get('security.context')->isGranted('ROLE_USER')) {// Logged in with user class
		    $user = $this->get('security.token_storage')->getToken()->getUser();

		    return $this->render(
			    'ZacjaBundle:index:index.html.twig',
			    array('username' => $user,
				    'signedIn' => true,
				    'trainings' => $trainings,
				    'conquers' => $conquers
			    )
		    );
	    }else{//not logged in, or logged with other class than user
		    return $this->render(


			    'ZacjaBundle:index:index.html.twig',
			    array('username' => 'stranger',
				    'signedIn' => false,
				    'trainings' => $trainings,
				    'conquers' => $conquers
			    )
		    );
	    }
    }

	public function getTrainings($limit = 16){
		$em = $this->getDoctrine()->getManager();
		$trainings_temp = $em->getRepository('ZacjaBundle:Training')->findBy(array(), array('id' => 'DESC'), $limit);

		$i = 0;
		foreach($trainings_temp as $training){
			$trainings[$i]["id"] = $training->getId();
			$trainings[$i]["type"] = $training->getType();
			$trainings[$i]["date"] = $training->getDate()->format('Y-m-d H:i:s');
			$trainings[$i]["user_id"] =  $training->getUserId();

			$user = $em->getRepository('ZacjaBundle:User')->findOneBy(array('id' => $training->getUserId()));

			$trainings[$i]["user_name"] = $user->getUsername();
			$i++;
		}

		return $trainings;
	}

	public  function getConquers($limit = 16){
		$em = $this->getDoctrine()->getManager();
		/*
		$dql = 'SELECT SUM(c.score) AS score, COUNT(*) as count GROUP BY userId';
		$conquers = $em->createQuery($dql)->getResult();

		$qb = $em->createQueryBuilder();
		$qb->select(
			'SUM(c.score) AS score',
			'COUNT(c.id)',
			'c.userId'
		)
			->from('ZacjaBundle\Entity\Conquer', 'c')
			->groupBy('c.userId')
			->setMaxResults( $limit );

		$conquers = $qb->getQuery()->getArrayResult();
		*/


		$sql = 'SELECT SUM(c.score) AS score, COUNT(*) as count, user_id, (SELECT username from user where id = user_id) as user_name FROM (SELECT * FROM Conquer ORDER BY id DESC LIMIT '.(int)$limit.') c GROUP BY user_id';

		$stmt = $em->getConnection()->prepare($sql);
		$stmt->execute();

		return $stmt->fetchAll();
	}
}

