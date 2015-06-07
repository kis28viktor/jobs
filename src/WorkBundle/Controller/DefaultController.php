<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WorkBundle\Entity\Employer;
use WorkBundle\Entity\Worker;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WorkBundle:Default:index.html.twig');
    }

    public function allIssuesAction(Request $request)
    {
        $selectedCity = $request->query->get('city');
        echo '<pre>';

        $employers = new Employer();
        $issuesData = array();
        if ($request->query->get('issueType')=='workers') {
            $issuesData = $this->generateWorkers($request);
        } elseif ($request->query->get('issueType') == 'employers') {
            $issuesData = $this->generateEmployers($request);
        } else {
            $issuesData = array_merge($this->generateEmployers($request), $this->generateWorkers($request));
        }
        var_dump($issuesData);die;
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
}
