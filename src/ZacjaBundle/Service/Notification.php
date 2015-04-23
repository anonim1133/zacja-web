<?php
namespace ZacjaBundle\Service;

use Doctrine\ORM\EntityManager;


class Notification {
	/**
	 *
	 * @var EntityManager
	 */
	protected $em;

	protected $content;
	protected $date;
	protected $url;

	public function __construct(EntityManager $entityManager){
		$this->em = $entityManager;

		$this->content = '';
		$this->date = time();
		$this->url = 'index';
	}

	/**
	 * @param string $content
	 */
	public function setContent($content){
		$this->content = $content;

		return $this;
	}

	/**
	 * @param int $date
	 */
	public function setDate($date){
		$this->date = $date;

		return $this;
	}

	/**
	 * @param string $url
	 */
	public function setUrl($url){
		$this->url = $url;

		return $this;
	}

	public function push($uid){
		$notification = array(
			'content' => $this->content,
			'date' => $this->date,
			'url' => $this->url
		);

		$profile = $this->em->getRepository("ZacjaBundle:User")->findOneById($uid)->getProfile();
		$profile->pushNotification($notification);

		$this->em->flush();
	}

}

$notification = array(
	'content' => 'Tell us about your self, fill your profile!',
	'date' => time(),
	'url' => 'editprofile'
);