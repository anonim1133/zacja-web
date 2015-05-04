<?php
namespace ZacjaBundle\Entity;

use Doctrine\ORM\EntityRepository;



class TrainingRepository extends EntityRepository {
	public function getLast($limit = 16){
		$cacheDriver = new \Doctrine\Common\Cache\ApcCache();

		if(!$cacheDriver->contains('last_trainings'.$limit)){
			$em = $this->getEntityManager();
			$trainings_temp = $em->getRepository('ZacjaBundle:Training')->findBy(array(), array('id' => 'DESC'), $limit);

			$i = 0;
			foreach($trainings_temp as $training){
				$trainings[$i]["id"] = $training->getId();
				$trainings[$i]["type"] = $training->getType();
				$trainings[$i]["score"] = $training->getScore();
				$trainings[$i]["date"] = $training->getDate()->format('Y-m-d H:i:s');
				$trainings[$i]["user_id"] =  $training->getUserId();

				$user = $em->getRepository('ZacjaBundle:User')->findOneBy(array('id' => $training->getUserId()));
				if(!is_null($user))
					$trainings[$i]["user_name"] = $user->getUsername();
				else
					$trainings[$i]["user_name"] = 'unknown';
				$i++;
			}

			$cacheDriver->save('last_trainings'.$limit, $trainings, 16);
		}else{
			$trainings = $cacheDriver->fetch('last_trainings'.$limit);
		}

		return $trainings;
	}

	public function findByUserName($username, $limit = 16){
		$em = $this->getEntityManager();

		$user = $em->getRepository("ZacjaBundle:User")->findOneByusername($username);


		if(!is_null($user)){
			$trainings = $em->getRepository("ZacjaBundle:Training")->findBy(array('userId' => $user->getId()), null, $limit);
			return $trainings;
		}else{
			return array();
		}
	}

	public function findByUsernameType($username, $type){
		$em = $this->getEntityManager();

		$user = $em->getRepository("ZacjaBundle:User")->findOneByusername($username);


		if(!is_null($user)){
			$trainings = $em->getRepository("ZacjaBundle:Training")->findBy(array('userId' => $user->getId(), 'type' => $type));
			return $trainings;
		}else{
			return array();
		}
	}

	public function findFriendsTrainings($username, $limit = 4){
		$cacheDriver = new \Doctrine\Common\Cache\ApcCache();

		if(!$cacheDriver->contains('friends_trainings_for_' . $username. '_limit_' . $limit)){
			$em = $this->getEntityManager();

			$user = $em->getRepository("ZacjaBundle:User")->findOneByusername($username);
			$friends = $user->getFriends();
			$friends->initialize();

			$trainings = $em->getRepository("ZacjaBundle:Training")->findBy(array('user' => $friends->toArray()), array('date' => 'DESC'),$limit);
			$cacheDriver->save('friends_trainings_for_' . $username. '_limit_' . $limit, $trainings, 64);
		}else{
			$trainings = $cacheDriver->fetch('friends_trainings_for_' . $username. '_limit_' . $limit);
		}

		return $trainings;
	}

	public function getTotalDistance($uid, $type){
		$distance = 0;

		$em = $this->getEntityManager();
		$qb = $em->createQueryBuilder();

		$qb->select('sum(t.distance)')
			->from('ZacjaBundle:Training', 't')
			->where('t.userId = ?1')
			->andWhere('t.type = ?2');
		$qb->setParameter(1, $uid);
		$qb->setParameter(2, $type);

		$query = $qb->getQuery();

		$distance = $query->getSingleResult()[1];

		return $distance;
	}

	public function getStepsByDay($uid, $date){
		$em = $this->getEntityManager();

		$dql = '
	        SELECT sum(t.moves) as steps, t.date as date
	        FROM ZacjaBundle:Training t
	        WHERE t.userId = ?1
	        AND t.type = ?2
	        AND DATE_DIFF(t.date, ?3) < 1';

		$query = $em->createQuery($dql);
		$query->setParameter(1, $uid);
		$query->setParameter(2, 'Walking');
		$query->setParameter(3, $date);

		return (int)$query->getSingleResult()['steps'];

	}
}