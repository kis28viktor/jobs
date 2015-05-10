<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EmployerController extends Controller
{
    public function findWorkerAction()
    {
        $workersRepository = $this->getEntityManager()->getRepository('WorkBundle:Worker');
        $workerModels = $workersRepository->findAll();
        $workers = array();
        foreach ($workerModels as $worker) {
            $workers[] = array('id' => $worker->getId(),
                               'name' => $worker->getName(),
                               'phone' => $worker->getPhone(),
                               'age' => $worker->getAge(),
                               'city' => $worker->getCity(),
                               'aboutMe' => $worker->getAboutMe(),
            );
        }
        return $this->render('WorkBundle:Employer:findWorker.html.twig', array('workers' => $workers));
    }

    public function postEmployerAction()
    {
        return $this->render('WorkBundle::layout.html.twig');
    }

    protected function getEntityManager()
    {
        return $this->getDoctrine()->getEntityManager();
    }
}
