<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WorkBundle\Entity\Category;
use WorkBundle\Entity\EducationLevel;
use WorkBundle\Entity\Gender;
use WorkBundle\Entity\Worker;

/**
 * Class WorkerController
 *
 * @package WorkBundle\Controller
 */
class WorkerController extends Controller
{
    public function postWorkerAction(Request $request)
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

    public function findWorkAction()
    {
        return $this->render('WorkBundle::layout.html.twig');
    }

    public function addWorkerAction(Request $request)
    {
        $formData = $request->request->all();
        if ($formData) {
            if ($this->checkFormData($formData)) {
                $em = $this->getEntityManager();
                /** @var \WorkBundle\Entity\Gender $gender */
                $gender = $this->getEntityManager()->getRepository('WorkBundle:Gender')->find($formData['gender']);
                $worker = new Worker();
                $worker->setFirstName($formData['firstName'])
                    ->setLastName($formData['lastName'])
                    ->setPhone($formData['phone'])
                    ->setGender($gender);
                if($formData['date']){
                    $date = new \DateTime($formData['date']);
                    $worker->setDate($date);
                }
                if($formData['city']){
                    $worker->setCity($formData['city']);
                }
                if($formData['aboutMe']){
                    $worker->setAboutMe($formData['aboutMe']);
                }
                if($formData['categories']){
                    foreach ($formData['categories'] as $category){
                        /** @var \WorkBundle\Entity\Category $categoryEntity */
                        $categoryEntity = $this->getEntityManager()->getRepository('WorkBundle:Category')->find($category);
                        $worker->addCategory($categoryEntity);
                    }
                }
//                echo '<pre>';
//                var_dump($formData);die;
                $em->persist($worker);
                $em->flush();
                echo 'Yes';





            } else {
                //todo: redirect back to addWorker page
            }
        } else {
            //todo: redirect back to addWorker page
        }

        return null;
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
}
