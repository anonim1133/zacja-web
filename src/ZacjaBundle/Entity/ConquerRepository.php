<?php
namespace ZacjaBundle\Entity;

use Doctrine\ORM\EntityRepository;


class ConquerRepository extends EntityRepository {
	public  function getLast($limit = 16){

		$cacheDriver = new \Doctrine\Common\Cache\ApcCache();

		if(!$cacheDriver->contains('conquers_limit_' . $limit)){
			$em = $this->getEntityManager();

			$sql = 'SELECT SUM(c.score) AS score, COUNT(*) as count, user_id, (SELECT username from user where id = user_id) as user_name FROM (SELECT * FROM Conquer ORDER BY id DESC LIMIT '.(int)$limit.') c GROUP BY user_id';

			$stmt = $em->getConnection()->prepare($sql);
			$stmt->execute();
			$conquers = $stmt->fetchAll();

			$cacheDriver->save('conquers_limit_' . $limit, $conquers, 32);
		}else{
			$conquers = $cacheDriver->fetch('conquers_limit_' . $limit);
		}

		return $conquers;
	}

	public function findByUserName($username, $limit = 16){
		$em = $this->getEntityManager();

		$user = $em->getRepository("ZacjaBundle:User")->findOneByusername($username);


		if(!is_null($user)){
			$conquers = $em->getRepository("ZacjaBundle:Conquer")->findBy(array('userId' => $user->getId()), null, $limit);

			return $conquers;
		}else{
			return array();
		}
	}

	public function findFriendsConquers($username, $limit = 4){
		$cacheDriver = new \Doctrine\Common\Cache\ApcCache();
		$conquers = array();

		if(!$cacheDriver->contains('friends_conquers_for_' . $username. '_limit_' . $limit)){
			$em = $this->getEntityManager();

			$user = $em->getRepository("ZacjaBundle:User")->findOneByusername($username);
			$friends = $user->getFriends();
			$friends->initialize();

			$conquers = $em->getRepository("ZacjaBundle:Conquer")->findBy(array('user' => $friends->toArray()), array('date' => 'DESC'),$limit);
			if(isset($conquers) && is_array($conquers))
				$cacheDriver->save('friends_conquers_for_' . $username. '_limit_' . $limit, $conquers, 64);
		}else{
			$conquers = $cacheDriver->fetch('friends_conquers_for_' . $username. '_limit_' . $limit);
		}

		return $conquers;
	}

	public  function getCount($uid){
		$em = $this->getEntityManager();

		$dql = 'SELECT COUNT(c)  FROM ZacjaBundle:Conquer c WHERE c.userId = ?1';

		$query = $em->createQuery($dql);
		$query->setParameter(1, $uid);

		return (int)$query->getSingleResult()[1];
	}
}