<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        echo 'yes';die;
        return $this->render('WorkBundle:Default:index.html.twig');
    }
}
