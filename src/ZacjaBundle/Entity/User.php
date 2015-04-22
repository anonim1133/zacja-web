<?php

namespace ZacjaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ZacjaBundle\Entity\UserRepository")
 * @UniqueEntity(fields="username", message="Username is already taken")
 * @UniqueEntity(fields="email", message="Email is already in use")
 *
 */
class User implements  UserInterface, \Serializable{
	public function __construct(){
		$this->friends = new ArrayCollection();
	}
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=64)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @var integer
     *
     * @ORM\Column(name="role", type="smallint")
     */
    private $roles;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registration_date", type="datetime")
     */
    private $registrationDate;


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
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return 'SaltedSalt';
        //return $this->salt;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set role
     *
     * @param integer $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get role
     *
     * @return Array of string
     */
    public function getRoles()
    {
        return array('ROLE_USER');



        if($this->roles === 0)
            return array('ROLE_USER');
        elseif($this->roles === -1){
            return array('ROLE_ADMIN');
        }else{
            return array('ROLE_UNKNOWN');
        }
    }

    /**
     * Set registrationDate
     *
     * @param \DateTime $registrationDate
     * @return User
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime 
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    //Funkcje
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

	/**
	 * @ORM\OneToOne(targetEntity="Profile", cascade={"persist"})
	 * @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
	 **/
	private $profile;

	/**
	 * @return Profile
	 */
	public function getProfile(){
		return $this->profile;
	}

	/**
	 * Set profile
	 *
	 * @param integer $profile
	 * @return User
	 */
	public function setProfile($profile)
	{
		$this->profile = $profile;

		return $this;
	}

	/**
	 * @ORM\ManyToMany(targetEntity="User")
	 * @ORM\JoinTable(name="friends")
	 **/
	private $friends;

	/**
	 * @return Friends
	 */
	public function getFriends(){
		return $this->friends;
	}

	/**
	 * Set Friends
	 *
	 * @param User $friends
	 * @return User
	 */
	public function setFriends($friends)
	{
		$this->friends = $friends;

		return $this;
	}

	/**
	 * @ORM\OneToOne(targetEntity="ZacjaBundle\Entity\Notification", cascade={"persist"})
	 * @ORM\JoinColumn(name="id", referencedColumnName="id")
	 **/
	private $notifications;

	/**
	 * @return array Notifications
	 */
	public function getNotifications(){
		return $this->notifications;
	}

	/**
	 * Set notifications
	 *
	 * @param array $notification
	 * @return User
	 */
	public function setNotifications($notifications){
		$this->notifications = $notifications;

		return $this;
	}

	public function pushNotification($notification){
		$this->notifications->setNotifications($notification);

		return $this;
	}
}
