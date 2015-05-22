<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WorkBundle\Entity\Category;
use WorkBundle\Entity\EducationLevel;

/**
 * Class WorkerController
 *
 * @package WorkBundle\Controller
 */
class WorkerController extends Controller
{
    public function postWorkerAction(Request $request)
    {
        $educationLevel = new EducationLevel();
        $category = new Category();
        return $this->render('WorkBundle:Worker:postWorker.html.twig',
            array('categories' => $category->getAllCategories($this->getEntityManager()),
                  'educationLevels' => $educationLevel->getAllEducationLevels($this->getEntityManager()),
                ));
    }

    public function findWorkAction()
    {
        return $this->render('WorkBundle::layout.html.twig');
    }
    public function addWorkerAction(Request $request)
    {
        $formData = $request->request->all();
        $checkBox = $formData;
        var_dump($checkBox);
        return null;
    }

    /**
     * Get Entity Manager
     *
     * @return \Doctrine\ORM\EntityManager|object
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getEntityManager();
    }
}
