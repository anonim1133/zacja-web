<?php

namespace ApiBundle\Controller;

use ApiBundle\Entity\ApiKeys;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ZacjaBundle\Entity\User;


class AuthController extends Controller{
    /**
     * @Route("/api/SignIn")
     * @Template()
     */
    public function SignInAction(){
        //Get user credentials
        $request = Request::createFromGlobals();
        $username = $request->query->get('login');
        $password = $request->query->get('password');

        $response = new Response();

        if(isset($username) && strlen($username) > 0 && isset($password) && strlen($password) > 0 ){
            //Authorize user
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('ZacjaBundle:User')->findOneBy(array('username' => $username, 'password' => $password));

            //Create response
            if(isset($user) && $user->getUsername() == $username){
                $key = $em->getRepository('ApiBundle:ApiKeys')->findOneBy(array('userId' => $user->getId()));

                if(isset($key) && $key->getApiKey() != 0){
                    $response->setContent($key->getApiKey());
                }else{

                    $key = md5('API' . time() . 'KEY_FOR_' . $user->getUsername());

                    $api_key = new ApiKeys();

                    $api_key->setUserId($user->getId());
                    $api_key->setApikey($key);
                    $api_key->setDate(time());

                    $em->persist($api_key);
                    $em->flush();

                    $response->setContent($key);
                }

                $response->setStatusCode(Response::HTTP_OK);
            }else{
                $response->setContent('false');
                $response->setStatusCode(Response::HTTP_FORBIDDEN);
            }

            //Generate response


            $response->headers->set('Content-Type', 'text/html');
            // prints the HTTP headers followed by the content


        }else{
            $response->setStatusCode(Response::HTTP_PARTIAL_CONTENT);
            $response->headers->set('Content-Type', 'text/html');
            $response->setContent('false');
        }
            return $response;
}

    /**
     * @Route("/api/SignUp")
     * @Template()
     */
    public function signUpAction(){
        //ToDo: Sprawdzać czy dany user nie istnieje
        $response = new Response();
        $em = $this->getDoctrine()->getManager();
        $request = Request::createFromGlobals();

        $username = $request->request->get('username');
        $password = $request->request->get('password');
        $email = $request->request->get('email');

        if(isset($username) & isset($password) & isset($email) & strlen($username) > 0 & strlen($password) > 0 & strlen($email) > 0){
            $salt = 'saltedSalt';
            $isActive = false;
            $roles = 0;
            $registrationDate = new \DateTime('now');

            $user = new User();
            $user->setUsername($username);
            $user->setPassword($password);
            $user->setEmail($email);
            $user->setSalt($salt);
            $user->setIsActive($isActive);
            $user->setRoles($roles);
            $user->setRegistrationDate($registrationDate);

            $em->persist($user);
            $em->flush();

            $response->headers->set('Content-Type', 'text/html');
            $response->setContent('true');
            $response->setStatusCode(Response::HTTP_ACCEPTED);

            return $response;
        }else{
            $response->headers->set('Content-Type', 'text/html');
            $response->setContent('false');
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);

            return $response;
        }
    }

    /**
     * @Route("/api/LoginCheck")
     * @Template()
     */
    public function CheckAction()
    {
        $request = Request::createFromGlobals();
        $key = $request->query->get('key');

        $em = $this->getDoctrine()->getManager();
        $key = $em->getRepository('ApiBundle:ApiKeys')->findOneBy(array('apikey' => $key));

        $response = new Response();

        if(isset($key)){
            $response->setContent($key->getUserId());
            $response->setStatusCode(Response::HTTP_OK);
        }else{
            $response->setContent('false');
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
        }

        $response->headers->set('Content-Type', 'text/html');
        // prints the HTTP headers followed by the content

        return $response;
        }

    /**
     * @Route("/api/Confirm")
     * @Template()
     */
    public function ConfirmAction()
    {
        return array(
                // ...
            );    }

}
