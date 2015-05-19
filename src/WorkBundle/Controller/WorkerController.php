<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WorkBundle\Entity\Forms\AddWorker;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class WorkerController
 *
 * @package WorkBundle\Controller
 */
class WorkerController extends Controller
{
    public function postWorkerAction()
    {
        $newWorker = new AddWorker();
        $form = $this->createFormBuilder($newWorker)
            ->add('firstName', 'text')
            ->add('lastName', 'text')
            ->add('phone', 'text')
            ->add('age', 'number')
            ->add('city', 'text')
            ->add('aboutMe', 'textarea', array('max_length' => 255))
            ->add('categories', 'choice', array(
                'label' => 'Chose your categories:',
                'choices' => $this->getAllCategories(),
                'multiple' => 'true',
                'expanded' => 'true',
            ))
            ->add('education','text')
            ->add('educationLevel', 'choice', array(
                'label' => 'Chose your education level:',
                'choices' => $this->getEducationLevels(),
            ))
            ->add('educationCity', 'text')
            ->add('addWorker', 'submit')
            ->getForm();
        return $this->render('WorkBundle:Worker:postWorker.html.twig', array('form' => $form->createView()));
    }

    public function findWorkAction()
    {
        return $this->render('WorkBundle::layout.html.twig');
    }
    public function addWorkerAction(Request $request)
    {
        $formData = $request->request->get('form');
        $checkBox = $formData['categories'];
        var_dump($checkBox);
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
     * Get all choices of education
     *
     * @return array
     */
    protected function getAllEducations()
    {
        $educationRepository = $this->getEntityManager()->getRepository('WorkBundle:Education');
        $educationModels = $educationRepository->findAll();
        $educations = array();
        if($educationRepository){
            /** @var \WorkBundle\Entity\Education $education */
            foreach($educationModels as $education) {
                $educations[$education->getId()] = $education->getName();
            }
        }
        return $educations;
    }

    /**
     * Get all categories
     *
     * @return array
     */
    protected function getAllCategories()
    {
        $categoryRepository = $this->getEntityManager()->getRepository('WorkBundle:Category');
        $categoryModels = $categoryRepository->findAll();
        $categories = array();
        if($categoryModels){
            /** @var \WorkBundle\Entity\Category $category */
            foreach ($categoryModels as $category) {
                $categories[$category->getId()] = $category->getName();
            }
        }
        return $categories;
    }

    /**
     * Get all education levels that is possible to choose.
     *
     * @return array
     */
    protected function getEducationLevels()
    {
        $educationLevelRepository = $this->getEntityManager()->getRepository('WorkBundle:EducationLevel');
        $levelModels = $educationLevelRepository->findAll();
        $levels = array();
        if($levelModels){
            /** @var \WorkBundle\Entity\EducationLevel $level */
            foreach ($levelModels as $level) {
                $levels[$level->getId()] = $level->getName();
            }
        }
        return $levels;
    }

}
