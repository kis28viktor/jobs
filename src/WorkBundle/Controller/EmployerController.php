<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EmployerController extends Controller
{
    public function findWorkerAction()
    {
        return $this->render('WorkBundle::layout.html.twig');
    }

    public function postEmployerAction()
    {
        return $this->render('WorkBundle::layout.html.twig');
    }
}
