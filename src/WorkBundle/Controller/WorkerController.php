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
        $em = $this->getEntityManager();
        $repository = $em->getRepository('WorkBundle:Category');
        $categoryModels = $repository->findAll();
        $categories = array();
        if($categoryModels){
            foreach ($categoryModels as $category) {
                $categories[$category->getId()] = $category->getName();
            }
        }
        $form = $this->createFormBuilder($newWorker)
            ->add('name', 'text')
            ->add('phone', 'text')
            ->add('age', 'text')
            ->add('city', 'text')
            ->add('aboutMe', 'text')
            ->add('addWorker', 'submit')
            ->add('categories', 'choice', array(
                'label' => 'Chose your categories:',
                'choices' => $categories,
                'multiple' => 'true',
                'expanded' => 'true',
            ))
            ->getForm();
        return $this->render('WorkBundle:Worker:postWorker.html.twig', array('form' => $form->createView()));
    }

    public function findWorkAction()
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
        return $this->render('WorkBundle:Worker:findWorker.html.twig', array('workers' => $workers));
    }

    public function addWorkerAction(Request $request)
    {
        $formData = $request->request->get('form');
        $checkBox = $formData['categories'];
        var_dump($checkBox);
        return null;
    }

    protected function getEntityManager()
    {
        return $this->getDoctrine()->getEntityManager();
    }

}
