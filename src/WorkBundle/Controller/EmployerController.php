<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function findWorkerAction(Request $request)
    {
        $workersRepository = $this->getEntityManager()->getRepository('WorkBundle:Worker');
        //Get workers older then 20 and from 'Some city
//        $workerModels = $workersRepository->createQueryBuilder('p')
//            ->where('p.age < :age','p.city = :city')
//            ->setParameter('age',20)
//            ->setParameter('city','Some city')
//            ->getQuery()
//            ->getResult();
        $workerModels = $workersRepository->findAll();
        $workers = array();
        $filter = new WorkerFilter();
        $filterForm = $this->createFormBuilder($filter)
                    ->add('city', 'text')
                    ->add('ageFrom', 'number')
                    ->add('ageTo', 'number')
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
}
