<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WorkBundle\Entity\Education;
use WorkBundle\Entity\EducationLevel;
use WorkBundle\Entity\Forms\WorkerFilter;
use Symfony\Component\HttpFoundation\Request;
use WorkBundle\Entity\Gender;
use WorkBundle\Entity\Worker;

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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function findWorkerAction(Request $request)
    {
        $workerModels = $this->getWorkers($request);
        $workers      = array();
        /** @var \WorkBundle\Entity\Worker $worker */
        foreach ($workerModels as $worker) {
            $workers[] = array('id'         => $worker->getId(),
                               'name'       => $worker->getFirstName() . ' ' . $worker->getLastName(),
                               'phone'      => $worker->getPhone(),
                               'age'        => $worker->getAge(),
                               'city'       => $worker->getCity(),
                               'aboutMe'    => $worker->getAboutMe(),
                               'categories' => $this->getCategoriesForWorker($worker->getId()),
                               'educations' => $this->getEducationsForWorker($worker->getId()),
            );
        }
        return $this->render(
            'WorkBundle:Employer:findWorker.html.twig',
            array('workers' => $workers,
                  'genders' => $this->getGenders(),
                  'city'    => $request->request->get('city') ? $request->request->get('city') : null,
                  'ageFrom' => $request->request->get('ageFrom') ? $request->request->get('ageFrom') : null,
                  'ageTo' => $request->request->get('ageTo') ? $request->request->get('ageTo') : null,
                  'gender' => $request->request->get('gender') ? $request->request->get('gender') : null,
            )
        );
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
        $workerRepository = $this->getEntityManager()->getRepository('WorkBundle:Worker')->findOneBy(
            array('id' => $workerId)
        );
        $categoryModels   = $workerRepository->getCategories()->getValues();
        $categories       = array();
        if ($categoryModels) {
            /** @var \WorkBundle\Entity\Category $category */
            foreach ($categoryModels as $category) {
                $categories[] = array(
                    'name' => $category->getName(),
                );
            }
            return $categories;
        } else {
            return array('The user didn`t chose any category.');
        }
    }

    /**
     * Getting all educations in array for worker (by worker id)
     *
     * @param int $workerId
     * @return array
     */
    protected function getEducationsForWorker($workerId)
    {
        $worker = new Worker();
        return $worker->getEducationForWorker($workerId, $this->getEntityManager());
    }

    /**
     * Get all genders
     *
     * @return array
     */
    protected function getGenders()
    {
        $gender = new Gender();
        return $gender->getAllGendersArray($this->getEntityManager());
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function getWorkers(Request $request)
    {
        $worker = new Worker();
        return $worker->getAllWorkersWithPostFilter($request, $this->getEntityManager());
    }
}
