<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WorkBundle\Entity\Category;
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
        $employer = new Employer();
        $gender = new Gender();
        $employers = $this->generateEmployersArray($employer->getAllEmployers($request, $this->getEntityManager()));
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($employers,$request->query->getInt('page', 1),5);
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
     * Generate array of employers for view
     *
     * @param $employersModels
     * @return array
     */
    protected function generateEmployersArray($employersModels)
    {
        $employers = array();
        $employerModel = new Employer();
        /** @var \WorkBundle\Entity\Employer $employer */
        foreach ($employersModels as $employer) {
            $employers[] = array(
                'id' => $employer->getId(),
                'name' => $employer->getFirstName() . ' ' . $employer->getLastName(),
                'phone' => $employer->getPhone(),
                'city' => $employer->getCity(),
                'aboutMe' => $employer->getAboutMe(),
                'ageFrom' => $employer->getAgeFrom(),
                'ageTo' => $employer->getAgeTo(),
                'priceFrom' => $employer->getPriceFrom(),
                'priceTo' => $employer->getPriceTo(),
                'termFrom' => $employer->getTermFrom()?$employer->getTermFrom()->format('Y-m-d'): 'Employer didn`t specified term from.',
                'termTo' => $employer->getTermTo()?$employer->getTermTo()->format('Y-m-d'): 'Employer didn`t specified term to.',
                'categories' => $employerModel->getCategoriesForEmployer($employer->getId(), $this->getEntityManager()),
                'postDate' => $employer->getPostDate()->format('Y-m-d'),
                );
        }
        return $employers;
    }
}
