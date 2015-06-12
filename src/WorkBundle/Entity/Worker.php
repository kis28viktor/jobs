<?php

namespace WorkBundle\Entity;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="worker")
 */
class Worker {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $firstName;
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $lastName;
    /**
     * @ORM\ManyToOne(targetEntity="Gender")
     */
    protected $gender;
    /**
     * @ORM\Column(type="string", length=50, nullable=true);
     */
    protected $phone;
    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $date;
    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $city;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $aboutMe;
    /**
     * @ORM\ManyToMany(targetEntity="Category", inversedBy="workers")
     * @ORM\JoinTable(name="workers_categories",
     * joinColumns={@ORM\JoinColumn(name="worker_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")})
     */
    protected $categories;
    /**
     * @ORM\ManyToMany(targetEntity="Education", inversedBy="workers")
     * @ORM\JoinTable(name="workers_education",
     * joinColumns={@ORM\JoinColumn(name="worker_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="education_id", referencedColumnName="id")})
     */
    protected $education;
    /**
     * @ORM\Column(type="date")
     */
    protected $postDate;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->education = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set phone
     *
     * @param string $phone
     * @return Worker
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set age
     *
     * @param \DateTime $date
     * @return Worker
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Worker
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set aboutMe
     *
     * @param string $aboutMe
     * @return Worker
     */
    public function setAboutMe($aboutMe)
    {
        $this->aboutMe = $aboutMe;

        return $this;
    }

    /**
     * Get aboutMe
     *
     * @return string
     */
    public function getAboutMe()
    {
        return $this->aboutMe;
    }

    /**
     * Add categories
     *
     * @param \WorkBundle\Entity\Category $categories
     * @return Worker
     */
    public function addCategory(\WorkBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \WorkBundle\Entity\Category $categories
     */
    public function removeCategory(\WorkBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add education
     *
     * @param \WorkBundle\Entity\Education $education
     * @return Worker
     */
    public function addEducation(\WorkBundle\Entity\Education $education)
    {
        $this->education[] = $education;

        return $this;
    }

    /**
     * Remove education
     *
     * @param \WorkBundle\Entity\Education $education
     */
    public function removeEducation(\WorkBundle\Entity\Education $education)
    {
        $this->education->removeElement($education);
    }

    /**
     * Get education
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Worker
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return Worker
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set gender
     *
     * @param \WorkBundle\Entity\Gender $gender
     * @return Worker
     */
    public function setGender(\WorkBundle\Entity\Gender $gender = null)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return \WorkBundle\Entity\Gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set postDate
     *
     * @param \DateTime $postDate
     * @return Worker
     */
    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;

        return $this;
    }

    /**
     * Get postDate
     *
     * @return \DateTime
     */
    public function getPostDate()
    {
        return $this->postDate;
    }

    /**
     * Get workers with checking post params
     *
     * @param Request $request
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $entityManager
     * @param bool $post
     * @return array
     */
    public function getAllWorkersWithPostFilter(Request $request, $entityManager, $post = true)
    {
        $workersRepository = $entityManager->getRepository('WorkBundle:Worker');
        if($post == true) {
            $filterData        = $request->request->all();
        } else {
            $filterData        = $request->query->all();
        }
        if ($filterData) {
            if (!empty($filterData['city']) || !empty($filterData['ageFrom'])
                || !empty($filterData['ageTo'])
                || (!empty($filterData['gender'])&& $filterData['gender'][0] != 'all')
                || (!empty($filterData['categories']) && $filterData['categories'][0] != 'all')
            ) {
                $whereCondition = '';
                $workerModels   = $workersRepository->createQueryBuilder('p');
                if ($filterData['city']) {
                    $workerModels->setParameter('city', $filterData['city']);
                    $whereCondition .= 'p.city = :city AND ';
                }
                if (!empty($filterData['ageFrom'])) {
                    $date = $this->getDateForAge($filterData['ageFrom']);
                    $workerModels->setParameter('ageFrom', $date);
                    $whereCondition .= 'p.date < :ageFrom AND ';
                }
                if (!empty($filterData['ageTo'])) {
                        $date = $this->getDateForAge($filterData['ageTo'], true);
                        $workerModels->setParameter('ageTo', $date);
                        $whereCondition .= 'p.date > :ageTo AND ';
                }
                if (isset($filterData['gender']) && $filterData['gender'][0] != 'all') {
                    $workerModels->setParameter('gender', $filterData['gender'][0]);
                    $whereCondition .= 'p.gender = :gender AND ';
                }
                if ($whereCondition=='') {
                    $workers = $workersRepository->findBy(array(), array('postDate' => 'DESC'));
                } else {
                    $workerModels->where(substr($whereCondition, 0, -5))->orderBy('p.postDate', 'DESC');
                    $workers = $workerModels->getQuery()->getResult();
                }
                if (isset($filterData['categories']) && $filterData['categories'][0] != 'all') {
                    $categoryModel = new Category();
                    /** @var \WorkBundle\Entity\Worker $worker */
                    foreach ($workers as $key => $worker) {
                        foreach($filterData['categories'] as $category) {
                            $curCategories = $worker->getCategories()->getValues();
                            if(!in_array($categoryModel->find($category, $entityManager), $curCategories)){
                                unset($workers[$key]);
                            }
                        }
                    }
                }
                return $workers;
            } else {
                $workerModels = $workersRepository->findBy(array(), array('postDate' => 'DESC'));
            }
        } else {
            $workerModels = $workersRepository->findBy(array(), array('postDate' => 'DESC'));
        }
        return $workerModels;
    }
    /**
     * @param int $workerId
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $entityManager
     * @return array
     */
    public function getEducationForWorker($workerId, $entityManager)
    {
        $workerRepository = $entityManager->getRepository('WorkBundle:Worker')->findOneBy(
            array('id' => $workerId)
        );
        $educationModels  = $workerRepository->getEducation()->getValues();
        if ($educationModels) {
            $educations = array();
            /** @var \WorkBundle\Entity\Education $education */
            foreach ($educationModels as $education) {
                /** @var \WorkBundle\Entity\EducationLevel $educationLevel */
                $educationLevel = $education->getLevel();
                $educations[]   = array(
                    'name'  => $education->getName() ? $education->getName() : 'Не вказано',
                    'level' => $educationLevel ? $educationLevel->getName() :  'Не вказано',
                    'city'  => $education->getCity() ? $education->getCity() : 'Не вказано',
                );
            }
            return $educations;
        } else {
            return array('Не вказано');
        }
    }

    /**
     * @param int $workerId
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $entityManager
     * @return array
     */
    public function getCategoriesForWorker($workerId, $entityManager)
    {
        $workerRepository = $entityManager->getRepository('WorkBundle:Worker')->findOneBy(
            array('id' => $workerId)
        );
        $categoryModels   = $workerRepository->getCategories()->getValues();
        $categories       = array();
        if ($categoryModels) {
            /** @var \WorkBundle\Entity\Category $category */
            foreach ($categoryModels as $category) {
                $categories[] = array(
                    'name' => $category->getName(),
                );
            }
            return $categories;
        } else {
            return array('Не вибрано жодної категорії');
        }
    }

    /**
     * @param bool $ageTo
     * @param int $age
     * @return string
     */
    protected function getDateForAge($age, $ageTo = false)
    {
        $dateModel = new \DateTime();
        if($ageTo){
            $age+=1;
            $date = new \DateInterval('P'. $age .'Y');
        } else {
            $date = new \DateInterval('P'.$age.'Y');
        }
        return $dateModel->sub($date)->format('Y-m-d');
    }

    /**
     * Worker saving by data filled in the form
     *
     * @param array $formData
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $em
     */
    public function saveWorker($formData, $em)
    {
        /** @var \WorkBundle\Entity\Gender $gender */
        $gender = $em->getRepository('WorkBundle:Gender')->find($formData['gender']);
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
                $categoryEntity = $em->getRepository('WorkBundle:Category')->find($category);
                $worker->addCategory($categoryEntity);
            }
        }
        $worker->setPostDate(new \DateTime());
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
                $educationLevel = $em->getRepository('WorkBundle:EducationLevel')->find($formData['educationLevel']);
                $education->setLevel($educationLevel);
            }
            $em->persist($education);
            $worker->addEducation($education);
        }
        $em->persist($worker);
        $em->flush();
    }

    /**
     * Removing the worker by id
     *
     * @param int $workerId
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $em
     */
    public function deleteWorker($workerId, $em)
    {
        $worker = $em->getRepository('WorkBundle:Worker')->find($workerId);
        if($worker){
            $em->remove($worker);
            $em->flush();
        }
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
     * Generate correct array of workers, that can be sent to the layout
     *
     * $workerModelsArray should be an array of Worker entities, which we take using doctrine manager
     *
     * @param array $workersModelsArray
     * @param \Doctrine\Common\Persistence\ObjectManager|\Doctrine\ORM\EntityManager|object $entityManager
     * @return array
     */
    public function generateWorkersArray($workersModelsArray, $entityManager)
    {
        $workerModel = new Worker();
        $workers      = array();
        /** @var \WorkBundle\Entity\Worker $worker */
        foreach ($workersModelsArray as $worker) {
            $tz  = new \DateTimeZone('Europe/Kiev');
            $workers[] = array('id'         => $worker->getId(),
                               'name'       => $worker->getFirstName() . ' ' . $worker->getLastName(),
                               'phone'      => $worker->getPhone(),
                               'age'        => $worker->getDate()?\DateTime::createFromFormat('d/m/Y', $worker->getDate()->format('d/m/Y'), $tz)
                                   ->diff(new \DateTime('now', $tz))
                                   ->y:'user didn`t specified his age.',
                               'city'       => $worker->getCity() ? $worker->getCity(): 'User didn`t specified the city.',
                               'aboutMe'    => $worker->getAboutMe() ? $worker->getAboutMe() : 'User didn`t filled any bio.',
                               'categories' => $workerModel->getCategoriesForWorker($worker->getId(), $entityManager),
                               'educations' => $workerModel->getEducationForWorker($worker->getId(), $entityManager),
                               'postDate' => $worker->getPostDate()->format('Y-m-d'),
            );
        }
        return $workers;
    }
}
