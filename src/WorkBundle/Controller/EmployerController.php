<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        if($request->cookies->get('city')){
            $request->request->set('city', $request->cookies->get('city'));
            $response = new Response();
            $response->headers->clearCookie('city', 'main');
            $response->send();
        }
        $workerModel = new Worker();
        $workers = $workerModel->generateWorkersArray($workerModel->getAllWorkersWithPostFilter($request, $this->getEntityManager()), $this->getEntityManager());
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($workers,$request->query->getInt('page', 1),25);
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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postWorkAction(Request $request)
    {
        if($request->cookies->get('city')){
            $request->request->set('city', $request->cookies->get('city'));
            $response = new Response();
            $response->headers->clearCookie('city', 'main');
            $response->send();
        }
        $category = new Category();
        $gender = new Gender();
        return $this->render('WorkBundle:Employer:postWork.html.twig',
            array(
                'categories' => $category->getAllCategories($this->getEntityManager()),
                'genders' => $gender->getAllGendersArray($this->getEntityManager()),
                'city' => $request->request->get('city') ? $request->request->get('city') : null,
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
                return $this->redirectToRoute('find_worker');
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
     * Check if user filled in his first name, last name and phone
     *
     * @param array $formData
     * @return bool
     */
    protected function checkFormData($formData)
    {
        return $formData['firstName'] && $formData['phone'] && $formData['gender'];
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
