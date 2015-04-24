<?php

namespace ZacjaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use ZacjaBundle\Entity\Comment;

class MikroblogController extends Controller
{
    /**
     * @Route("/mikroblog", name="mikroblog")
     * @Template()
     */
    public function showAction(Request $request)
    {
	    $signed_in = false;
	    $username = null;

	    $path = '/mikroblog';

	    $form = $this->createFormBuilder()
		    ->add('content', 'textarea')
		    ->add('save', 'submit', array('label' => 'Add entry'))
		    ->getForm();

	    if($this->get('security.context')->isGranted('ROLE_USER')){//signed in
		    $username = $this->get('security.token_storage')->getToken()->getUser();
		    $signed_in = true; //if signed in, then can submit new comments

		    $form->handleRequest($request);

		    if($form->isValid()){
			    $em = $this->getDoctrine()->getEntityManager();
			    $data = $form->getData(); // add comment
			    $session = $request->getSession();

			    $time = time() - $session->get('last_comment_time');

			    if($session->get('last_comment') != $path . $data['content'] && $time > 8){//resubmission protection
				    $user = $this->getDoctrine()->getRepository("ZacjaBundle:User")->findOneByUsername($username);

				    $comment = new Comment();
				    $comment->setDate(new \DateTime());
				    $comment->setPath($path);
				    $comment->setContent($data['content']);
				    $comment->setAuthor($user);

				    $em->persist($comment);
				    $em->flush();

				    $session->set('last_comment', $path . $data['content']);
				    $session->set('last_comment_time', time());
			    }
		    }

	    }
	    $comments = $this->getDoctrine()->getRepository("ZacjaBundle:Comment")->findByPath($path, array('id' => 'DESC'), 64);

	    return $this->render(
		    'ZacjaBundle:Mikroblog:show.html.twig',
		    array('form' => $form->createView(),
			    'username' => $username,
			    'signed_in' => $signed_in,
			    'comments' => $comments)
	    );
    }

}
