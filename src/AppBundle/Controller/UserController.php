<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/users/new", name="users_new")
     */
    public function newAction()
    {
        return $this->render('user/new.html.twig', array(
            'data' => 'Test text from UserController.php'
        ));
    }

    /**
     * @Route("/users", name="users_list")
     */
    public function listAction()
    {
        return new Response('TODO');
    }
}
