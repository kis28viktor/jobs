<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EmployerController
 *
 * @package WorkBundle\Controller
 */
class EmployerController extends Controller
{
    /**
     * Action which displays a list of workers
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function findWorkerAction()
    {
        $workersRepository = $this->getEntityManager()->getRepository('WorkBundle:Worker');
        $workerModels = $workersRepository->findAll();
        $workers = array();
        /** @var \WorkBundle\Entity\Worker $worker */
        foreach ($workerModels as $worker) {
            $workers[] = array('id' => $worker->getId(),
                               'name' => $worker->getName(),
                               'phone' => $worker->getPhone(),
                               'age' => $worker->getAge(),
                               'city' => $worker->getCity(),
                               'aboutMe' => $worker->getAboutMe(),
                                'categories' => $this->getCategoriesForWorker($worker->getId()),
            );
        }
        return $this->render('WorkBundle:Employer:findWorker.html.twig', array('workers' => $workers));
    }

    /**
     * Post an issue about possible work
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postEmployerAction()
    {
        return $this->render('WorkBundle::layout.html.twig');
    }

    /**
     * Get Entity Manager
     *
     * @return \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object
     */
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getEntityManager();
    }

    /**
     * Getting all categories in array for worker (by worker id)
     *
     * @param int $workerId
     * @return array
     */
    protected function getCategoriesForWorker($workerId)
    {
        $categoryRepository = $this->getEntityManager()->getRepository('WorkBundle:Worker')->findOneBy(array('id' => $workerId));
        $categoryModels = $categoryRepository->getCategories()->getValues();
        $categories = array();
        /** @var \WorkBundle\Entity\Category $category */
        foreach ($categoryModels as $category) {
            $categories[] = array(
                            'id' => $category->getId(),
                            'name' => $category->getName(),
            );
        }
        return $categories;
    }
}
