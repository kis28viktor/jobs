<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HireController extends Controller
{
    public function findAction()
    {
        return $this->render('WorkBundle::layout.html.twig');
    }

    public function postAction()
    {
        return $this->render('WorkBundle::layout.html.twig');
    }
}