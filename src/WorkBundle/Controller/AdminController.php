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
//        if ($issuesType && $issuesType=='workers') {
           $worker = new Worker();
            $data = $worker->getAllWorkersWithPostFilter($request, $this->getEntityManager());
            var_dump($data);die;
//        }
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
