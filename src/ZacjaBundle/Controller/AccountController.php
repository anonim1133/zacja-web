<?php

namespace ZacjaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use ZacjaBundle\Entity\User;
use ZacjaBundle\Form\Model\Login;
use ZacjaBundle\Form\Type\LoginType;
use ZacjaBundle\Form\Type\RegistrationType;
use ZacjaBundle\Form\Model\Registration;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class AccountController extends Controller
{
    /**
     * @Route("/signIn", name="signIn")
     * @Method("POST")
     * @Template()
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function signInAction(Request $request){
        $request = $this->getRequest();
        $session = $request->getSession();

        //Get user credentials from POST form
        $username = $request->request->get('autorization')['user']['username'];
        $password = $request->request->get('autorization')['user']['password'];


        //Authorize user
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('ZacjaBundle:User')->findOneBy(array('username' => $username, 'password' => $password));


        if(isset($user)){
            //Authenticate user
            $token = new UsernamePasswordToken($user->getUsername(), $user->getPassword(), 'main', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);
            $session->set('_security_main',  serialize($token));

            // get the login error if there is one
            if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
                $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
                if(isset($error)) $error = $error.message;
            } else {
                $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
                if(isset($error)) $error = $error.message;
            }
        }else{
            $error = 'Could find user with that username/password combination';
        }

        if(isset($error)){
            $login_form = new Login();
            $form = $this->createForm(new LoginType(), $login_form, array(
                'action' => $this->generateUrl('signIn'),
            ));

            return $this->render(
                'ZacjaBundle:Account:showSignIn.html.twig',
                array('form' => $form->createView(),
                    'error' => $error
                )
            );
        }

        if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirect($this->generateUrl('index'), 301);
        }
    }

    /**
     * @Route("/signIn")
     * @Route("/login")
     * @Method("GET")
     * @Template("ZacjaBundle:Account:signIn.html.twig")
     */
    public function showSignInAction(){
        $login_form = new Login();
        $form = $this->createForm(new LoginType(), $login_form, array(
            'action' => $this->generateUrl('signIn'),
        ));

        return $this->render(
            'ZacjaBundle:Account:showSignIn.html.twig',
            array('form' => $form->createView(),
                  'error' => '')
        );
    }

    /**
     * @Route("/signUp", name="signUp")
     * @Method("POST")
     * @Template()
     */
    public function signUpAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new RegistrationType(), new Registration());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $registration = $form->getData();

            $registration->getUser()->setSalt('saltedSalt');
            $registration->getUser()->setPassword($registration->getUser()->getPassword());
            $registration->getUser()->setIsActive(false);
            $registration->getUser()->setRoles(0);
            $registration->getUser()->setRegistrationDate(new \DateTime('now'));

            $em->persist($registration->getUser());
            $em->flush();

            return $this->redirect($this->generateUrl('index'), 301);
        }

        return $this->render(
            'ZacjaBundle:Account:showSignUp.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/signUp")
     * @Method("GET")
     * @Template("ZacjaBundle:Account:signUp.html.twig")
     */
    public function showSignUpAction(){
        $registration = new Registration();
        $form = $this->createForm(new RegistrationType(), $registration, array(
            'action' => $this->generateUrl('signUp'),
        ));

        return $this->render(
            'ZacjaBundle:Account:showSignUp.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/signOut")
     * @Template("ZacjaBundle:Account:signOut.html.twig")
     */
    public function signOutAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/verifyEmail")
     * @Template("ZacjaBundle:Account:verifyEmail.html.twig")
     */
    public function verifyEmailAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/resetPassword")
     * @Template("ZacjaBundle:Account:resetPassword.html.twig")
     */
    public function resetPasswordAction()
    {
        return array(
                // ...
            );    }

}
