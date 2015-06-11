<?php

namespace WorkBundle\Controller;

use Proxies\__CG__\WorkBundle\Entity\Category;
use Proxies\__CG__\WorkBundle\Entity\Gender;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WorkBundle\Entity\Employer;
use WorkBundle\Entity\Worker;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        if($request->query->get('city')){
            $cityCookie = new Cookie('city', $request->query->get('city'), 0, 'find_worker',null, false, false);
            $cityCookie2 = new Cookie('city', $request->query->get('city'), 0, 'find_work',null, false, false);
            $response = new Response();
            $response->headers->setCookie($cityCookie);
            $response->headers->setCookie($cityCookie2);
            $response->send();
        }
        return $this->render('WorkBundle:Default:index.html.twig');
    }

    public function allIssuesAction(Request $request)
    {
        $category = new Category();
        $gender = new Gender();
        if ($this->getFirst($request->query->get('issueType'))=='workers') {
            $issuesData = $this->generateWorkers($request);
        } elseif ($this->getFirst($request->query->get('issueType')) == 'employers') {
            $issuesData = $this->generateEmployers($request);
        } else {
            $issuesData = array_merge($this->generateEmployers($request), $this->generateWorkers($request));
        }
        $paginator = $this->get('knp_paginator');
        $viewData = $paginator->paginate($issuesData,$request->query->getInt('page', 1),5);
        return $this->render('WorkBundle:Default:allIssues.html.twig',array(
            'issuesData' => $viewData,
            'genders' => $gender->getAllGendersArray($this->getEntityManager()),
            'city'    => $request->query->get('city') ? $request->query->get('city') : null,
            'gender' => $request->query->get('gender') ? $request->query->get('gender') : null,
            'categories' => $category->getAllCategories($this->getEntityManager()),
            'curCategory' => $request->query->get('categories')? $this->getFirst($request->query->get('categories')) : null,
            'curIssueType' => $request->query->get('issueType')? $this->getFirst($request->query->get('issueType')) : null,
        ));
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
     * Generate workers array for combined list
     *
     * @param Request $request
     * @return array
     */
    protected function generateWorkers($request)
    {
        $workers = new Worker();
        $workersArray = $workers->generateWorkersArray($workers->getAllWorkersWithPostFilter($request, $this->getEntityManager(), false),$this->getEntityManager());
        foreach($workersArray as $key => $worker) {
            unset($workersArray[$key]['age']);
            unset($workersArray[$key]['educations']);
        }
        return $workersArray;
    }

    /**
     * Generate employers array for combined list
     *
     * @param Request $request
     * @return array
     */
    protected function generateEmployers($request)
    {
        $employers = new Employer();
        $employersArray = $employers->generateEmployersArray($employers->getAllEmployersByFilter($request, $this->getEntityManager(), false),$this->getEntityManager());
        foreach($employersArray as $key => $worker) {
            unset($employersArray[$key]['ageFrom']);
            unset($employersArray[$key]['ageTo']);
            unset($employersArray[$key]['priceFrom']);
            unset($employersArray[$key]['priceTo']);
            unset($employersArray[$key]['termFrom']);
            unset($employersArray[$key]['termTo']);
        }
        return $employersArray;
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
