<?php
namespace ZacjaBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use ZacjaBundle\Entity\User;

class Login
{
	/**
	 * @Assert\Type(type="ZacjaBundle\Entity\User")
	 * @Assert\Valid()
	 */
	protected $user;

	/**
	 * @Assert\NotBlank()
	 * @Assert\True()
	 */

	public function setUser(User $user)
	{
		$this->user = $user;
	}

	public function getUser()
	{
		return $this->user;
	}
}