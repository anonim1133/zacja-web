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
			/*
			$qb = $em->createQueryBuilder();
			$qb->select('c')
				->from('ZacjaBundle\Entity\Conquer', 'c')
				->leftJoin('e.relatedEntity', 'r')
				->where('c.userId = ?1')
				->setMaxResults( $limit )
				->setParameter(1, $user->getId());

			return $qb->getQuery()->getArrayResult();*/
			return $conquers;
		}else{
			return array();
		}
	}
}