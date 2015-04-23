<?php
namespace ZacjaBundle\Service;

use Doctrine\ORM\EntityManager;


class Badge {
	/**
	 *
	 * @var EntityManager
	 */
	protected $em;

	public function __construct(EntityManager $entityManager){
		$this->em = $entityManager;
	}

	public function add($uid, $bid){
		$badge = $this->em->getRepository("ZacjaBundle:Badge")->findOneById($bid);
		$profile = $this->em->getRepository("ZacjaBundle:User")->findOneById($uid)->getProfile();

		$profile->getBadges()->add($badge);

		$this->em->flush();
	}

}