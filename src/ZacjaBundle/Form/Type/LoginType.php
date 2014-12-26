<?php
namespace ZacjaBundle\Form\Type;

use Symfony\Bundle\SecurityBundle\Tests\Functional\Bundle\CsrfFormLoginBundle\Form\UserLoginFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('user', new UserLoginType());
		$builder->add('SignIn', 'submit');
	}

	public function getName()
	{
		return 'autorization';
	}
}