<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WorkBundle\Entity\Worker;

class WorkerController extends Controller
{
    public function postWorkerAction()
    {
        return $this->render('WorkBundle:Worker:post.html.twig');
    }

    public function findWorkAction()
    {
        return $this->render('WorkBundle:Worker:find.html.twig');
    }

}
