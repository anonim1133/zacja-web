<?php

namespace ZacjaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profile
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ZacjaBundle\Entity\ProfileRepository")
 */
class Profile
{

	public function __construct()
	{
		$this->badges = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255, nullable=true)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="pseudonym", type="string", length=255, nullable=true)
     */
    private $pseudonym;

    /**
     * @var integer
     *
     * @ORM\Column(name="score", type="integer", nullable=true)
     */
    private $score;

    /**
     * @var integer
     *
     * @ORM\Column(name="level", type="integer", nullable=true)
     */
    private $level;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @var string
     *
     * @ORM\Column(name="about", type="string", length=512, nullable=true)
     */
    private $about;


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
     * Set name
     *
     * @param string $name
     * @return Profile
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return Profile
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set pseudonym
     *
     * @param string $pseudonym
     * @return Profile
     */
    public function setPseudonym($pseudonym)
    {
        $this->pseudonym = $pseudonym;

        return $this;
    }

    /**
     * Get pseudonym
     *
     * @return string 
     */
    public function getPseudonym()
    {
        return $this->pseudonym;
    }

    /**
     * Set score
     *
     * @param integer $score
     * @return Profile
     */
    public function setScore($score){
        $this->score += $score;


	    $score = $this->score;
	    $nextLevel = 24;


	    $level = 0;
	    while(true){
		    $nextLevel = ($level <= 1)?1024:ceil($nextLevel*2 + (($nextLevel/16) * ($level==0?1:$level)));

		    if($score >= $nextLevel) $level++;
		    elseif($level < 1) $level = 1;
		    else break;
	    }

	    $this->setLevel($level);

        return $this;
    }

    /**
     * Get score
     *
     * @return integer 
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Profile
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

	/**
	 * Get points for next level
	 * @return integer
	 */
	public function getPointsForNextLevel(){
		$score = $this->score;
		$nextLevel = 24;


		$level = 0;
		while(true){
			$nextLevel = ($level <= 1)?1024:ceil($nextLevel*2 + (($nextLevel/16) * ($level==0?1:$level)));

			if($score >= $nextLevel) $level++;
			elseif($level < 1) $level = 1;
			else break;
		}

		return (integer)$nextLevel;
	}

	/**
	 * Get points for next level
	 * @return integer
	 */
	public function getPointsToNextLevel(){
		$points = $this->getPointsForNextLevel();

		return $points - $this->score;
	}
    /**
     * Set avatar
     *
     * @param string $avatar
     * @return Profile
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set about
     *
     * @param string $about
     * @return Profile
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    /**
     * Get about
     *
     * @return string 
     */
    public function getAbout()
    {
        return $this->about;
    }

	/**
	 * @ORM\ManyToMany(targetEntity="Badge", inversedBy="captors")
	 * @ORM\JoinTable(name="badges_users_own")
	 **/
	private $badges;

	/**
	 * @return Badge
	 */
	public function getBadges(){
		return $this->badges;
	}

	/**
	 * Set Badge
	 *
	 * @param integer $badgeId
	 * @return Badge
	 */
	public function setBadges($badges)
	{
		$this->badges = $badges;

		return $this;
	}
}
