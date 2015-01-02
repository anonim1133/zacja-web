<?php

namespace ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthControllerTest extends WebTestCase
{
    public function testSignin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/SignIn');
    }

    public function testSignup()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/SignUp');
    }

    public function testCheck()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/LoginCheck');
    }

    public function testConfirm()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/Confirm');
    }

}
