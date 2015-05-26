<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WorkBundle\Entity\Category;
use WorkBundle\Entity\Employer;
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
        $workerModel = new Worker();
        $workersData = $workerModel->getAllWorkersWithPostFilter($request, $this->getEntityManager());
        $workers = $this->generateWorkersArray($workersData);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($workers,$request->query->getInt('page', 1),5);
        $gender = new Gender();
        return $this->render(
            'WorkBundle:Employer:findWorker.html.twig',
            array('pagination' => $pagination,
                  'genders' => $gender->getAllGendersArray($this->getEntityManager()),
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
    public function postWorkAction()
    {
        $category = new Category();
        $gender = new Gender();
        return $this->render('WorkBundle:Employer:postWork.html.twig',
            array(
                'categories' => $category->getAllCategories($this->getEntityManager()),
                'genders' => $gender->getAllGendersArray($this->getEntityManager()),

        ));
    }

    public function addWorkAction(Request $request)
    {
        echo '<pre>';
        print_r($request->request->all());die;
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
     * Generate correct array of workers, that can be sent to the layout
     *
     * $workerModelsArray should be an array of Worker entities, which we take using doctrine manager
     *
     * @param array $workersModelsArray
     * @return array
     */
    protected function generateWorkersArray($workersModelsArray)
    {
        $workerModel = new Worker();
        $workers      = array();
        /** @var \WorkBundle\Entity\Worker $worker */
        foreach ($workersModelsArray as $worker) {
            $tz  = new \DateTimeZone('Europe/Kiev');
            $workers[] = array('id'         => $worker->getId(),
                               'name'       => $worker->getFirstName() . ' ' . $worker->getLastName(),
                               'phone'      => $worker->getPhone(),
                               'age'        => $worker->getDate()?\DateTime::createFromFormat('d/m/Y', $worker->getDate()->format('d/m/Y'), $tz)
                                                ->diff(new \DateTime('now', $tz))
                                                ->y:'user didn`t specified his age.',
                               'city'       => $worker->getCity() ? $worker->getCity(): 'User didn`t specified the city.',
                               'aboutMe'    => $worker->getAboutMe() ? $worker->getAboutMe() : 'User didn`t filled any bio.',
                               'categories' => $workerModel->getCategoriesForWorker($worker->getId(), $this->getEntityManager()),
                               'educations' => $workerModel->getEducationForWorker($worker->getId(), $this->getEntityManager()),
            );
        }
        return $workers;
    }
}
