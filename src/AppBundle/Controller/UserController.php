<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /**
     * @Route("/users/new", name="users_new")
     */
    public function newAction()
    {
        return $this->render('user/new.html.twig', array(
            'data' => 'Test text here'
        ));
    }
}
