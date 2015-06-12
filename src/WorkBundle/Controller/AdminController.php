<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WorkBundle\Entity\Category;
use WorkBundle\Entity\Employer;
use WorkBundle\Entity\Gender;
use WorkBundle\Entity\Worker;

class AdminController extends Controller
{
    /**
     * Index action
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $gender = new Gender();
        $category = new Category();
        $issuesType = $request->request->get('issueType');
        $issuesData = $this->getIssuesData($issuesType, $request);
        $this->sortingByPostDate($issuesData);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($issuesData,$request->query->getInt('page', 1),10);
        return $this->render('WorkBundle:Admin:issues.html.twig', array(
            'issuesData' => $pagination,
            'genders' => $gender->getAllGendersArray($this->getEntityManager()),
            'city'    => $request->request->get('city') ? $request->request->get('city') : null,
            'gender' => $request->request->get('gender') ? $request->request->get('gender') : null,
            'categories' => $category->getAllCategories($this->getEntityManager()),
            'curCategory' => $request->request->get('categories')? $this->getFirst($request->request->get('categories')) : null,
            'curIssueType' => $request->request->get('issueType')? $this->getFirst($request->request->get('issueType')) : null,
        ));
    }

    /**
     * Getting information for index action
     *
     * @param   array      $issuesType
     * @param Request $request
     * @return array
     */
    protected function getIssuesData($issuesType, Request $request)
    {
        if ($issuesType && $issuesType[0]=='workers') {
            $worker = new Worker();
            $issuesData = $worker->generateWorkersArray($worker->getAllWorkersWithPostFilter($request, $this->getEntityManager()), $this->getEntityManager());
            foreach($issuesData as $key => $issue){
                $issuesData[$key]['issueType'] = 'worker';
            }
        } elseif($issuesType && $issuesType[0]=='employers') {
            $employer = new Employer();
            $issuesData = $employer->generateEmployersArray($employer->getAllEmployersByFilter($request,$this->getEntityManager()),$this->getEntityManager());
            foreach($issuesData as $key => $issue){
                $issuesData[$key]['issueType'] = 'employer';
            }
        } else {
            $issuesData = array_merge($this->generateEmployers($request), $this->generateWorkers($request));
        }
        return $issuesData;
    }

    /**
     * Delete issue action
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteIssueAction(Request $request)
    {
        if($request->query->get('issueType') == 'employer'){
            $employer = new Employer();
            $employer->deleteEmployer($request->query->get('id'), $this->getEntityManager());
            $this->addFlash('notice', "Issue has been successfully deleted.");
        } elseif($request->query->get('issueType') == 'worker') {
            $worker = new Worker();
            $worker->deleteWorker($request->query->get('id'), $this->getEntityManager());
            $this->addFlash('notice', "Issue has been successfully deleted.");
        }
        return $this->redirectToRoute('admin_issues');
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
        $workersArray = $workers->generateWorkersArray($workers->getAllWorkersWithPostFilter($request, $this->getEntityManager()),$this->getEntityManager());
        foreach($workersArray as $key => $worker) {
            unset($workersArray[$key]['age']);
            unset($workersArray[$key]['educations']);
            $workersArray[$key]['issueType'] = 'worker';
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
        $employersArray = $employers->generateEmployersArray($employers->getAllEmployersByFilter($request, $this->getEntityManager()),$this->getEntityManager());
        foreach($employersArray as $key => $worker) {
            unset($employersArray[$key]['ageFrom']);
            unset($employersArray[$key]['ageTo']);
            unset($employersArray[$key]['priceFrom']);
            unset($employersArray[$key]['priceTo']);
            unset($employersArray[$key]['termFrom']);
            unset($employersArray[$key]['termTo']);
            $employersArray[$key]['issueType'] = 'employer';
        }
        return $employersArray;
    }

    /**
     * Sorting issues data by post date
     *
     * @param array $dataArray
     */
    protected function sortingByPostDate(&$dataArray)
    {
        for ($i=1; $i<count($dataArray); $i++) {
            $flag = false;
            for ($j = count($dataArray)-1;$j>=$i;$j--) {
                if($dataArray[$j-1]['postDate']< $dataArray[$j]['postDate'])
                {
                    $tmp = $dataArray[$j - 1];
                    $dataArray[$j - 1] = $dataArray[$j];
                    $dataArray[$j] = $tmp;
                    $flag = true;
                }
            }
            if(!$flag){
                break;
            }
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
