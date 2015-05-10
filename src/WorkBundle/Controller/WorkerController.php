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
            /** @var \WorkBundle\Entity\Category $category */
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
        return $this->render('WorkBundle::layout.html.twig');
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
