<?php

namespace ZacjaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Training
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Training
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
     * @var integer
     *
     * @ORM\Column(name="score", type="integer")
     */
    private $score;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="time", type="integer", nullable=true)
     */
    private $time;

    /**
     * @var integer
     *
     * @ORM\Column(name="time_active", type="integer", nullable=true)
     */
    private $timeActive;

    /**
     * @var integer
     *
     * @ORM\Column(name="moves", type="integer", nullable=true)
     */
    private $moves;

    /**
     * @var float
     *
     * @ORM\Column(name="speed_max", type="float", nullable=true)
     */
    private $speedMax;

    /**
     * @var float
     *
     * @ORM\Column(name="speed_avg", type="float", nullable=true)
     */
    private $speedAvg;

    /**
     * @var float
     *
     * @ORM\Column(name="tempo_min", type="float", nullable=true)
     */
    private $tempoMin;

    /**
     * @var float
     *
     * @ORM\Column(name="tempo_avg", type="float", nullable=true)
     */
    private $tempoAvg;

    /**
     * @var float
     *
     * @ORM\Column(name="distance", type="float", nullable=true)
     */
    private $distance;

    /**
     * @var integer
     *
     * @ORM\Column(name="altitude_min", type="integer", nullable=true)
     */
    private $altitudeMin;

    /**
     * @var integer
     *
     * @ORM\Column(name="altitude_max", type="integer", nullable=true)
     */
    private $altitudeMax;

    /**
     * @var integer
     *
     * @ORM\Column(name="altitude_upward", type="integer", nullable=true)
     */
    private $altitudeUpward;

    /**
     * @var integer
     *
     * @ORM\Column(name="altitude_downward", type="integer", nullable=true)
     */
    private $altitudeDownward;

    /**
     * @var string
     *
     * @ORM\Column(name="gpx", type="text", nullable=true)
     */
    private $gpx;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;


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
     * Set score
     *
     * @param integer $score
     * @return Training
     */
    public function setScore($score)
    {
        $this->score = $score;

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
     * Set date
     *
     * @param \DateTime $date
     * @return Training
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
     * Set type
     *
     * @param string $type
     * @return Training
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set time
     *
     * @param integer $time
     * @return Training
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return integer 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set timeActive
     *
     * @param integer $timeActive
     * @return Training
     */
    public function setTimeActive($timeActive)
    {
        $this->timeActive = $timeActive;

        return $this;
    }

    /**
     * Get timeActive
     *
     * @return integer 
     */
    public function getTimeActive()
    {
        return $this->timeActive;
    }

    /**
     * Set moves
     *
     * @param integer $moves
     * @return Training
     */
    public function setMoves($moves)
    {
        $this->moves = $moves;

        return $this;
    }

    /**
     * Get moves
     *
     * @return integer 
     */
    public function getMoves()
    {
        return $this->moves;
    }

    /**
     * Set speedMax
     *
     * @param float $speedMax
     * @return Training
     */
    public function setSpeedMax($speedMax)
    {
        $this->speedMax = $speedMax;

        return $this;
    }

    /**
     * Get speedMax
     *
     * @return float 
     */
    public function getSpeedMax()
    {
        return $this->speedMax;
    }

    /**
     * Set speedAvg
     *
     * @param float $speedAvg
     * @return Training
     */
    public function setSpeedAvg($speedAvg)
    {
        $this->speedAvg = $speedAvg;

        return $this;
    }

    /**
     * Get speedAvg
     *
     * @return float 
     */
    public function getSpeedAvg()
    {
        return $this->speedAvg;
    }

    /**
     * Set tempoMin
     *
     * @param float $tempoMin
     * @return Training
     */
    public function setTempoMin($tempoMin)
    {
        $this->tempoMin = $tempoMin;

        return $this;
    }

    /**
     * Get tempoMin
     *
     * @return float 
     */
    public function getTempoMin()
    {
        return $this->tempoMin;
    }

    /**
     * Set tempoAvg
     *
     * @param float $tempoAvg
     * @return Training
     */
    public function setTempoAvg($tempoAvg)
    {
        $this->tempoAvg = $tempoAvg;

        return $this;
    }

    /**
     * Get tempoAvg
     *
     * @return float 
     */
    public function getTempoAvg()
    {
        return $this->tempoAvg;
    }

    /**
     * Set distance
     *
     * @param float $distance
     * @return Training
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance
     *
     * @return float 
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set altitudeMin
     *
     * @param integer $altitudeMin
     * @return Training
     */
    public function setAltitudeMin($altitudeMin)
    {
        $this->altitudeMin = $altitudeMin;

        return $this;
    }

    /**
     * Get altitudeMin
     *
     * @return integer 
     */
    public function getAltitudeMin()
    {
        return $this->altitudeMin;
    }

    /**
     * Set altitudeMax
     *
     * @param integer $altitudeMax
     * @return Training
     */
    public function setAltitudeMax($altitudeMax)
    {
        $this->altitudeMax = $altitudeMax;

        return $this;
    }

    /**
     * Get altitudeMax
     *
     * @return integer 
     */
    public function getAltitudeMax()
    {
        return $this->altitudeMax;
    }

    /**
     * Set altitudeUpward
     *
     * @param integer $altitudeUpward
     * @return Training
     */
    public function setAltitudeUpward($altitudeUpward)
    {
        $this->altitudeUpward = $altitudeUpward;

        return $this;
    }

    /**
     * Get altitudeUpward
     *
     * @return integer 
     */
    public function getAltitudeUpward()
    {
        return $this->altitudeUpward;
    }

    /**
     * Set altitudeDownward
     *
     * @param integer $altitudeDownward
     * @return Training
     */
    public function setAltitudeDownward($altitudeDownward)
    {
        $this->altitudeDownward = $altitudeDownward;

        return $this;
    }

    /**
     * Get altitudeDownward
     *
     * @return integer 
     */
    public function getAltitudeDownward()
    {
        return $this->altitudeDownward;
    }

    /**
     * Set gpx
     *
     * @param string $gpx
     * @return Training
     */
    public function setGpx($gpx)
    {
        $this->gpx = $gpx;

        return $this;
    }

    /**
     * Get gpx
     *
     * @return string 
     */
    public function getGpx()
    {
        return $this->gpx;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return Training
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
