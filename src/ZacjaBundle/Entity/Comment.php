<?php

namespace ZacjaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="ZacjaBundle\Entity\CommentRepository")
 */
class Comment{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="author_id", type="integer")
     */
    private $author_id;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=2048)
     */
    private $content;


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
     * Set date
     *
     * @param \DateTime $date
     * @return Comment
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set author_id
     *
     * @param integer $author_id
     * @return Comment
     */
    public function setAuthorId($author)
    {
        $this->author_id = $author;

        return $this;
    }

    /**
     * Get author_id
     *
     * @return integer 
     */
    public function getAuthorId()
    {
        return $this->author_id;
    }

	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
	 **/
	private $author;

	/**
	 * @return User
	 */
	public function getAuthor(){
		return $this->author;
	}

	/**
	 * Set Author
	 *
	 * @param User $user
	 * @return Comment
	 */
	public function setAuthor($user){
		$this->author = $user;

		$this->author_id = $user->getId();

		return $this;
	}

    /**
     * Set path
     *
     * @param string $path
     * @return Comment
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }
}
