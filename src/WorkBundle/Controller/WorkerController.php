<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WorkBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use WorkBundle\Entity\EducationLevel;
use WorkBundle\Entity\Employer;
use WorkBundle\Entity\Gender;
use WorkBundle\Entity\Worker;

/**
 * Class WorkerController
 *
 * @package WorkBundle\Controller
 */
class WorkerController extends Controller
{
    /**
     * Post worker action
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postWorkerAction()
    {
        $educationLevel = new EducationLevel();
        $category       = new Category();
        $gender         = new Gender();
        return $this->render(
            'WorkBundle:Worker:postWorker.html.twig',
            array('categories'      => $category->getAllCategories($this->getEntityManager()),
                  'educationLevels' => $educationLevel->getAllEducationLevels($this->getEntityManager()),
                  'genders'         => $gender->getAllGendersArray($this->getEntityManager()),
            )
        );
    }

    /**
     * Find work action
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function findWorkAction(Request $request)
    {
        if($request->cookies->get('city')){
            $request->request->set('city', $request->cookies->get('city'));
            $response = new Response();
            $response->headers->clearCookie('city','main');
            $response->send();
        }
        $employer = new Employer();
        $gender = new Gender();
        $category = new Category();
        $employers = $employer->generateEmployersArray($employer->getAllEmployersByFilter($request, $this->getEntityManager()), $this->getEntityManager());
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($employers,$request->query->getInt('page', 1),20);
        return $this->render('WorkBundle:Worker:findWork.html.twig',
            array(
                'pagination' => $pagination,
                'genders' => $gender->getAllGendersArray($this->getEntityManager()),
                'city'    => $request->request->get('city') ? $request->request->get('city') : null,
                'ageFrom' => $request->request->get('ageFrom') ? $request->request->get('ageFrom') : null,
                'ageTo' => $request->request->get('ageTo') ? $request->request->get('ageTo') : null,
                'termFrom' => $request->request->get('termFrom') ? $request->request->get('termFrom') : null,
                'termTo' => $request->request->get('termTo') ? $request->request->get('termTo') : null,
                'priceFrom' => $request->request->get('priceFrom') ? $request->request->get('priceFrom') : null,
                'priceTo' => $request->request->get('priceTo') ? $request->request->get('priceTo') : null,
                'gender' => $request->request->get('gender') ? $request->request->get('gender') : null,
                'categories' => $category->getAllCategories($this->getEntityManager()),
                'curCategory' => $request->request->get('categories')? $this->getFirst($request->request->get('categories')) : null,
            )
        );
    }

    /**
     * Add worker
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addWorkerAction(Request $request)
    {
        $formData = $request->request->all();
        if ($formData) {
            if ($this->checkFormData($formData)) {
                $worker = new Worker();
                $worker->saveWorker($formData, $this->getEntityManager());
                return $this->redirectToRoute('find_worker');
            } else {
                return $this->redirectToRoute('post_worker');
            }
        } else {
            return $this->redirectToRoute('post_worker');
        }
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
