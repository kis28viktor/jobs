<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WorkBundle\Entity\Category;
use WorkBundle\Entity\Education;
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
                $this->saveWorker($formData);
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
     * Check if at least on of the education forms is filled in
     *
     * @param array $formData
     * @return bool
     */
    protected function checkEducationFilling($formData)
    {
        return isset($formData['educationLevel']) || isset($formData['educationCity']) || isset($formData['education']);
    }

    /**
     * Worker saving by array parameters from POST
     *
     * @param array $formData
     */
    protected function saveWorker($formData)
    {
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
        if(isset($formData['categories'])){
            foreach ($formData['categories'] as $category){
                /** @var \WorkBundle\Entity\Category $categoryEntity */
                $categoryEntity = $this->getEntityManager()->getRepository('WorkBundle:Category')->find($category);
                $worker->addCategory($categoryEntity);
            }
        }
        if($this->checkEducationFilling($formData)){
            $education = new Education();
            if($formData['education']){
                $education->setName($formData['education']);
            }
            if($formData['educationCity']){
                $education->setName($formData['educationCity']);
            }
            if(isset($formData['educationLevel'])){
                /** @var \WorkBundle\Entity\EducationLevel $educationLevel */
                $educationLevel = $this->getEntityManager()->getRepository('WorkBundle:EducationLevel')->find($formData['educationLevel']);
                $education->setLevel($educationLevel);
            }
            $em->persist($education);
            $worker->addEducation($education);
        }
        $em->persist($worker);
        $em->flush();
    }
}
