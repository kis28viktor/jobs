<?php

namespace WorkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use WorkBundle\Entity\Gender;
use WorkBundle\Entity\Worker;

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
        $workerModel = new Worker();
        $workersData = $workerModel->getAllWorkersWithPostFilter($request, $this->getEntityManager());
        $workers = $this->generateWorkersArray($workersData);
        $gender = new Gender();
        return $this->render(
            'WorkBundle:Employer:findWorker.html.twig',
            array('workers' => $workers,
                  'genders' => $gender->getAllGendersArray($this->getEntityManager()),
                  'city'    => $request->request->get('city') ? $request->request->get('city') : null,
                  'ageFrom' => $request->request->get('ageFrom') ? $request->request->get('ageFrom') : null,
                  'ageTo' => $request->request->get('ageTo') ? $request->request->get('ageTo') : null,
                  'gender' => $request->request->get('gender') ? $request->request->get('gender') : null,
            )
        );
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
     * Generate correct array of workers, that can be sent to the layout
     *
     * $workerModelsArray should be an array of Worker entities, which we take using doctrine manager
     *
     * @param array $workersModelsArray
     * @return array
     */
    protected function generateWorkersArray($workersModelsArray)
    {
        $workerModel = new Worker();
        $workers      = array();
        /** @var \WorkBundle\Entity\Worker $worker */
        foreach ($workersModelsArray as $worker) {
            $tz  = new \DateTimeZone('Europe/Kiev');
            $workers[] = array('id'         => $worker->getId(),
                               'name'       => $worker->getFirstName() . ' ' . $worker->getLastName(),
                               'phone'      => $worker->getPhone(),
                               'age'        => \DateTime::createFromFormat('d/m/Y', $worker->getDate()->format('d/m/Y'), $tz)
                                                ->diff(new \DateTime('now', $tz))
                                                ->y,
                               'city'       => $worker->getCity(),
                               'aboutMe'    => $worker->getAboutMe(),
                               'categories' => $workerModel->getCategoriesForWorker($worker->getId(), $this->getEntityManager()),
                               'educations' => $workerModel->getEducationForWorker($worker->getId(), $this->getEntityManager()),
            );
        }
        return $workers;
    }
}
