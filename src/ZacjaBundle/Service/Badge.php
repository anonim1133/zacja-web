<?php
namespace ZacjaBundle\Service;

use Doctrine\ORM\EntityManager;


class Badge {
	/**
	 *
	 * @var EntityManager
	 */
	protected $em;
	protected $notification;

	public function __construct(EntityManager $entityManager, Notification $notification){
		$this->em = $entityManager;
		$this->notification = $notification;
	}

	public function add($uid, $bid){
		$badge = $this->em->getRepository("ZacjaBundle:Badge")->findOneById($bid);
		$profile = $this->em->getRepository("ZacjaBundle:User")->findOneById($uid)->getProfile();

		$badges = $profile->getBadges()->getValues();
		$duplicate = false;
		foreach($badges as $badge){
			if($badge->getId() == $bid) $duplicate = true;
		}

		if(!$duplicate){
			$profile->getBadges()->add($badge);

			$this->notification->setContent('You just got new Badge!')->push($uid);
		}


		$this->em->flush();
	}

}