<?php

namespace ZacjaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Notification
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ZacjaBundle\Entity\NotificationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Notification
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\Column(name="notifications", type="array")
     */
    private $notifications;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set notifications
     *
     * @param array $notification
     * @return Notification
     */
    public function setNotifications($notification){
	    array_unshift($this->notifications, $notification);

	    if(count($this->notifications) > 5)
		    array_pop($this->notifications);

        return $this;
    }

    /**
     * Get notifications
     *
     * @return array 
     */
    public function getNotifications(){
        return $this->notifications;
    }

	/** @ORM\PrePersist */
	public function onPrePersist(){
		$this->notifications = array(array('content' => 'Succesful registration! Now start playing for your life!', 'date' => time(), 'url' => 'index'));
	}
}
