<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WorkBundle\Entity\EducationLevel;
use WorkBundle\Entity\Forms\WorkerFilter;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EmployerController
 *
 * @package WorkBundle\Controller
 */
class EmployerController extends Controller
{
    /**
     * Action which displays a list of workers
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function findWorkerAction(Request $request)
    {
        $workerModels = $this->getWorkers($request);
        $workers = array();
        $filter = new WorkerFilter();
        $filterForm = $this->createFormBuilder($filter)
                    ->add('city', 'text', array('required' => false))
                    ->add('ageFrom', 'number',array('required' => false))
                    ->add('ageTo', 'number', array('required' => false))
                    ->add('gender', 'choice', array(
                        'label' => 'gender:',
                        'choices' => $this->getGenders(),
                        'placeholder' => 'gender',
                        'required' => false,
                    ))
                    ->add('find', 'submit')
                    ->getForm();
        /** @var \WorkBundle\Entity\Worker $worker */
        foreach ($workerModels as $worker) {
            $workers[] = array('id' => $worker->getId(),
                               'name' => $worker->getFirstName() . ' ' . $worker->getLastName(),
                               'phone' => $worker->getPhone(),
                               'age' => $worker->getAge(),
                               'city' => $worker->getCity(),
                               'aboutMe' => $worker->getAboutMe(),
                                'categories' => $this->getCategoriesForWorker($worker->getId()),
                                'educations' => $this->getEducationsForWorker($worker->getId()),
            );
        }
        return $this->render('WorkBundle:Employer:findWorker.html.twig', array('workers' => $workers, 'filterForm' => $filterForm->createView()));
    }

    /**
     * Post an issue about possible work
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postEmployerAction()
    {
        return $this->render('WorkBundle::layout.html.twig');
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
     * Getting all categories in array for worker (by worker id)
     *
     * @param int $workerId
     * @return array
     */
    protected function getCategoriesForWorker($workerId)
    {
        $workerRepository = $this->getEntityManager()->getRepository('WorkBundle:Worker')->findOneBy(array('id' => $workerId));
        $categoryModels = $workerRepository->getCategories()->getValues();
        $categories = array();
        if ($categoryModels) {
            /** @var \WorkBundle\Entity\Category $category */
            foreach ($categoryModels as $category) {
                $categories[] = array(
                    'name' => $category->getName(),
                );
            }
            return $categories;
        } else {
            return array('The user didn`t chose any category.');
        }
    }

    /**
     * Getting all educations in array for worker (by worker id)
     *
     * @param int $workerId
     * @return array
     */
    protected function getEducationsForWorker($workerId)
    {
        $workerRepository = $this->getEntityManager()->getRepository('WorkBundle:Worker')->findOneBy(array('id' => $workerId));
        $educationModels = $workerRepository->getEducation()->getValues();
        if ($educationModels) {
            $educations = array();
            /** @var \WorkBundle\Entity\Education $education */
            foreach ($educationModels as $education) {
                /** @var \WorkBundle\Entity\EducationLevel $educationLevel */
                $educationLevel = $education->getLevel();
                $educations[] = array(
                    'name' => $education->getName(),
                    'level' => $educationLevel->getName(),
                    'city' => $education->getCity(),
                );
            }
            return $educations;
        } else {
            return array('No education');
        }

    }

    /**
     * Get all genders
     *
     * @return array
     */
    protected function getGenders()
    {
        $genderRepository = $this->getEntityManager()->getRepository('WorkBundle:Gender');
        $genderModels = $genderRepository->findAll();
        $genders = array();
        if ($genderModels) {
            /** @var \WorkBundle\Entity\Gender $gender */
            foreach ($genderModels as $gender) {
               $genders[$gender->getId()] = $gender->getName();
           }
        }
        return $genders;
    }

    protected function getWorkers(Request $request)
    {
        $workersRepository = $this->getEntityManager()->getRepository('WorkBundle:Worker');
        $filterData = $request->request->get('form');
        if($filterData['city']||$filterData['ageFrom']||$filterData['ageTo']||$filterData['gender']){
            $whereCondition = '';
            $workerModels = $workersRepository->createQueryBuilder('p');
            if($filterData['city']){
                $workerModels->setParameter('city', $filterData['city']);
                $whereCondition .= 'p.city = :city AND ';
            }
            if($filterData['ageFrom']){
                $workerModels->setParameter('ageFrom', $filterData['ageFrom']);
                $whereCondition .= 'p.age >= :ageFrom AND ';

            }
            if($filterData['ageTo']){
                $workerModels->setParameter('ageTo', $filterData['ageTo']);
                $whereCondition .= 'p.age <= :ageTo AND ';
            }
            if($filterData['gender']){
                $workerModels->setParameter('gender', $filterData['gender']);
                $whereCondition .= 'p.gender = :gender AND ';
            }
            $workerModels->where(substr($whereCondition,0,-5));
                $workers = $workerModels->getQuery()->getResult();
            return $workers;
        } else {
            $workerModels = $workersRepository->findAll();
        }
        return $workerModels;
    }
}
