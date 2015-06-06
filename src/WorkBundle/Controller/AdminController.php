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
    public function indexAction(Request $request)
    {
        $issuesType = $request->request->get('issuesType');
        if ($issuesType && $issuesType=='workers') {
           $worker = new Worker();
            $workersData = $worker->generateWorkersArray($worker->getAllWorkersWithPostFilter($request, $this->getEntityManager()), $this->getEntityManager());
            var_dump($workersData);die;
        } elseif($issuesType && $issuesType=='employers') {
            $employer = new Employer();
            $employersData = $employer->generateEmployersArray($employer->getAllEmployersByFilter($request,$this->getEntityManager()),$this->getEntityManager());
            var_dump($employersData);die;
        }
        return $this->render('WorkBundle:Admin:issues.html.twig');
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
}
