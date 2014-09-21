<?php

namespace Syndic\CommentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('SyndicCommentBundle:Default:index.html.twig', array('name' => $name));
    }
}
