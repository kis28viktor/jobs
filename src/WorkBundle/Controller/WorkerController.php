<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WorkBundle\Entyty\Worker;

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

    public function addWorker()
    {
        $worker = new Worker();
        $em = $this->getDoctrine()->getManager();

    }
}