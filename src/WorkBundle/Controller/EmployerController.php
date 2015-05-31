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
        $workers = $this->generateWorkersArray($workerModel->getAllWorkersWithPostFilter($request, $this->getEntityManager()));
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($workers,$request->query->getInt('page', 1),5);
        $gender = new Gender();
        $category = new Category();
        return $this->render(
            'WorkBundle:Employer:findWorker.html.twig',
            array('pagination' => $pagination,
                  'genders' => $gender->getAllGendersArray($this->getEntityManager()),
                  'city'    => $request->request->get('city') ? $request->request->get('city') : null,
                  'ageFrom' => $request->request->get('ageFrom') ? $request->request->get('ageFrom') : null,
                  'ageTo' => $request->request->get('ageTo') ? $request->request->get('ageTo') : null,
                  'gender' => $request->request->get('gender') ? $request->request->get('gender') : null,
                  'categories' => $category->getAllCategories($this->getEntityManager()),
                  'curCategory' => $request->request->get('categories')? $this->getFirst($request->request->get('categories')) : null,
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

    /**
     * Add work action
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addWorkAction(Request $request)
    {
        $formData = $request->request->all();
        if($formData){
            if($this->checkFormData($formData)) {
                $employer = new Employer();
                $employer->saveEmployer($formData, $this->getEntityManager());
                return $this->redirectToRoute('find_work');
            } else {
                return $this->redirectToRoute('post_work');
            }
        } else {
            return $this->redirectToRoute('post_work');
        }
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
                                'postDate' => $worker->getPostDate()->format('Y-m-d'),
            );
        }
        return $workers;
    }

    /**
     * Check if user filled in his first name, last name and phone
     *
     * @param array $formData
     * @return bool
     */
    protected function checkFormData($formData)
    {
        return $formData['firstName'] && $formData['lastName'] && $formData['phone'] && $formData['gender'];
    }

    /**
     * Get first element from an array
     *
     * @param $array
     * @return mixed
     */
    protected function getFirst($array)
    {
        return array_shift($array);
    }
}
