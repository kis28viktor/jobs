<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WorkBundle\Entity\Forms\AddWorker;
use Symfony\Component\HttpFoundation\Request;

class WorkerController extends Controller
{
    public function postWorkerAction()
    {
        $newWorker = new AddWorker();
        $newWorker->setName('Ibrahim');
        $form = $this->createFormBuilder($newWorker)
            ->add('name', 'text')
            ->add('phone', 'text')
            ->add('age', 'text')
            ->add('city', 'text')
            ->add('aboutMe', 'text')
            ->add('addWorker', 'submit')
            ->getForm();
        return $this->render('WorkBundle:Worker:postWorker.html.twig', array('form' => $form->createView()));
    }

    public function findWorkAction()
    {
        return $this->render('WorkBundle:Worker:find.html.twig');
    }

    public function addWorkerAction()
    {
        return $this->render('WorkBundle::layout.html.twig');
    }

}
