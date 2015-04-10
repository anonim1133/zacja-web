<?php
namespace ZacjaBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;


class ConquerRepository extends EntityRepository {
	public  function getLast($limit = 16){
		$em = $this->getEntityManager();
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

	public function findByUserName($username, $limit = 16){
		$em = $this->getEntityManager();

		$user = $em->getRepository("ZacjaBundle:User")->findOneByusername($username);


		if(!is_null($user)){
			$conquers = $em->getRepository("ZacjaBundle:Conquer")->findByuser_id($user->getId());
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