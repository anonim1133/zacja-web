<?php

namespace ZacjaBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthenticateControllerTest extends WebTestCase
{
    public function testSignin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/signIn');
    }

    public function testShowsignin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showSignIn');
    }

    public function testSignup()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/signUp');
    }

    public function testShowsignup()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/showSignUp');
    }

    public function testSignout()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/signOut');
    }

    public function testVerifyemail()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/verifyEmail');
    }

    public function testResetpassword()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/resetPassword');
    }

}
