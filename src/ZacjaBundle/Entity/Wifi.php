<?php

namespace ZacjaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wifi
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Wifi
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
     * @var string
     *
     * @ORM\Column(name="ssid", type="string", length=32)
     */
    private $ssid;

    /**
     * @var string
     *
     * @ORM\Column(name="bssid", type="string", length=32)
     */
    private $bssid;

    /**
     * @var integer
     *
     * @ORM\Column(name="signal", type="integer")
     */
    private $signal;

    /**
     * @var integer
     *
     * @ORM\Column(name="security", type="integer")
     */
    private $security;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float")
     */
    private $longitude;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float")
     */
    private $latitude;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
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
     * Set ssid
     *
     * @param string $ssid
     * @return Wifi
     */
    public function setSsid($ssid)
    {
        $this->ssid = $ssid;

        return $this;
    }

    /**
     * Get ssid
     *
     * @return string 
     */
    public function getSsid()
    {
        return $this->ssid;
    }

    /**
     * Set bssid
     *
     * @param string $bssid
     * @return Wifi
     */
    public function setBssid($bssid)
    {
        $this->bssid = $bssid;

        return $this;
    }

    /**
     * Get bssid
     *
     * @return string 
     */
    public function getBssid()
    {
        return $this->bssid;
    }

    /**
     * Set signal
     *
     * @param integer $signal
     * @return Wifi
     */
    public function setSignal($signal)
    {
        $this->signal = $signal;

        return $this;
    }

    /**
     * Get signal
     *
     * @return integer 
     */
    public function getSignal()
    {
        return $this->signal;
    }

    /**
     * Set security
     *
     * @param integer $security
     * @return Wifi
     */
    public function setSecurity($security)
    {
        $this->security = $security;

        return $this;
    }

    /**
     * Get security
     *
     * @return integer 
     */
    public function getSecurity()
    {
        return $this->security;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return Wifi
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return Wifi
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return Wifi
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
